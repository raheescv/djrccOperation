<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Validator;
use Response;
use DB;
use Form;
use Auth;
use Session;
use Mail;
use App\Models\User;
use App\Models\UserType;
use App\Models\Profile;
use App\Models\ProjectModule;
use App\Models\Audit;
use App\Models\UserTypePrivilege;
use Yajra\Datatables\Datatables;
class UsersController extends Controller
{
  public function SignUp() {
    return view('users.signup');
  }
  public function Register(Request $request) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $data['nick_name']=$data['name'];
      $data['user_type_id']=3;
      $data['password']=str_random(8);
      $test=new User;
      $validator = Validator::make($data,$test->rules);
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
      $User=User::create($data);
      // $MailController = new MailController;
      // $return=$MailController->PasswordRecoveryMail($User);
      $return['result']='success';
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      return back()->withInput()->withErrors($e->getMessage());
    }
    toastr()->success('Please Check Your Email','Result');
    return redirect('/SignUp');
  }
  public function AddUser(Request $request) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $data['nick_name']=$data['name'];
      $data['status']=1;
      $data['flag']=1;
      $test=new User;
      $validator = Validator::make($data,$test->rules);
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
      if($data['password']!=$data['password_confirm']) throw new Exception("Password Does not Match", 1);
      unset($data['password_confirm']);
      $User=User::create($data);
      // $MailController = new MailController;
      // $return=$MailController->PasswordRecoveryMail($User);
      // if($return['result']!='success') throw new Exception($return['result']);
      $return['result']='success';
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      return back()->withInput()->withErrors($e->getMessage());
    }
    return redirect('/User/'.$User->id);
  }
  public function getUser($id) {
    $User=User::find($id);
    return response()->json($User);
  }
  public function UpdateUser(Request $request,$id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $rules = [
        'name'        =>'required|unique:users,name,'.$id,
        'user_type_id'=>'required',
        'email'       =>'required|unique:users,email,'.$id,
      ];
      $test=new User;
      $validator = Validator::make($data,$rules);
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
      $User=User::find($id);
      if(isset($data['image_upload'])) {
        $image_upload = $request->file('image_upload');
        $input['image_uploadname'] = $image_upload->getClientOriginalName().time().'.'.$image_upload->getClientOriginalExtension();
        $destinationPath = public_path('/profile');
        $image_upload->move($destinationPath, $input['image_uploadname']);
        $data['image']=$input['image_uploadname'];
        unset($data['image_upload']);
      }
      $User->update($data);
      DB::commit();
      $return['result']='success';
    } catch (Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
      return back()->withInput()->withErrors($return['result']);
    }
    return back()->withInput()->with($return['result']);
  }
  public function UpdateUserPassword(Request $request) {
    DB::beginTransaction();
    try {
      $id=Auth::user()->id;
      $data=$request->all();
      $rules = [
        'old_password'         =>'required',
        'password'             =>'required|min:6|same:password',
        'password_confirmation'=>'required|min:6|same:password',
      ];
      $test=new User;
      $validator = Validator::make($data,$rules);
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
      $User=User::find($id);
      if($data['old_password']!=$User->password) throw new Exception("Current Password must match with old password", 1);
      if($data['password']!=$data['password_confirmation']) throw new Exception("Password Does not Match", 1);
      $User->password=$data['password'];
      $User->save();
      DB::commit();
      $return['result']='success';
    } catch (Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
      return back()->withInput()->withErrors($return['result']);
    }
    return back()->withInput()->with($return['result']);
  }
  public function Login(Request $request) {
    try {
      $data=$request->all();
      $User=User::where('name',$data['username'])
      ->where('password',$data['password'])
      ->first();
      if(!$User) throw new Exception("UserName Or Password Mismatch", 1);
      Session::put('user_id', $User->id);
      Auth::login($User);
    } catch (Exception $e) {
      return back()->withInput()->withErrors($e->getMessage());
    }
    $_previous=Session('_previous');
    $url[3]='';
    if($_previous)
    {
      $url=explode('/', $_previous['url']);
      if(isset($url[3])) { if($url[3]=='SignIn') $url[3]=''; } else { $url[3]=''; }
    }
    return redirect('/');
  }
  public function User($id) {
    $User=User::find($id);
    if(Auth::user()->id==1) {
      $UserTypes=UserType::orderBy('name','asc')->pluck('name','id');
    } else {
      $UserTypes=UserType::orderBy('name','asc')->where('id','=',$User->user_type_id)->pluck('name','id');
    }
    $Users=User::all();
    $Audits=Audit::whereuser_id($id)->get(['user_id','event','auditable_type','old_values','new_values','url','created_at']);
    return view('users.user')
    ->with('Audits',$Audits)
    ->with('id',$id)
    ->with('User',$User)
    ->with('Users',$Users)
    ->with('UserTypes',$UserTypes)
    ;
  }
  public function SignIn() {
    return view('users.signin');
  }
  public function Logout(Request $request) {
    Session::flush();
    return redirect('SignIn');
  }
  public function profile() {
    $Profile=Profile::first();
    return view('users.profile')->with('Profile',$Profile);
  }
  public function profile_update(Request $request) {
    try {
      $data=$request->all();
      $Profile = Profile::first();
      if(isset($data['logo_upload'])) {
        $logo_upload = $request->file('logo_upload');
        $input['logo_uploadname'] = $logo_upload->getClientOriginalName().time().'.'.$logo_upload->getClientOriginalExtension();
        $destinationPath = public_path('/profile');
        $logo_upload->move($destinationPath, $input['logo_uploadname']);
        $data['logo']=$input['logo_uploadname'];
      }
      if(isset($data['image_upload'])) {
        $image_upload = $request->file('image_upload');
        $input['image_uploadname'] = $image_upload->getClientOriginalName().time().'.'.$image_upload->getClientOriginalExtension();
        $destinationPath = public_path('/profile');
        $image_upload->move($destinationPath, $input['image_uploadname']);
        $data['image']=$input['image_uploadname'];
      }
      $Profile->update($data);
      return redirect()->back()->with('message', 'Success');
    } catch (Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }
  }
  public function Lists() {
    if(Auth::user()->id==1) {
      $UserTypes=UserType::orderBy('name','asc')->pluck('name','id');
    } else {
      $UserTypes=UserType::orderBy('name','asc')->where('id','=',Auth::user()->user_type_id)->pluck('name','id');
    }
    $User=User::all();
    return view('users.list')
    ->with('User',$User)
    ->with('UserTypes',$UserTypes)
    ;
  }
  public function UserTypePrivileges() {
    $UserTypes=UserType::orderBy('name','asc')->pluck('name','id');
    return view('users.user_type_privilages')->with('UserTypes',$UserTypes);
  }
  public function UserTypePrivileges_Table_ajax(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='module';
    $column[]='sub_module';
    $column[]='id';
    $column[]='id';
    $UserType=UserType::find($request['user_type_id']);
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    if($request->input('search.value')) {
      $search=$request->input('search.value');
      $datas=ProjectModule::where('id','like',"%{$search}%");
      $datas->orwhere('module'        ,'like',"%{$search}%");
      $datas->orwhere('sub_module'    ,'like',"%{$search}%");
      $datas->orderBy($order,$dir);
      if($UserType->id!=1) $datas->where('sub_module','!=','UserTypePrivileges');
      $datas=$datas->get();
    } else {
      $datas=ProjectModule::orderBy($order,$dir);
      if($UserType->id!=1) $datas->where('sub_module','!=','UserTypePrivileges');
      $datas=$datas->get();
    }
    return Datatables::of($datas)
    ->addIndexColumn()
    ->addColumn('status', function($value) use($UserType){
      $UserTypePrivilege=UserTypePrivilege::where('user_type_id',$UserType->id)->where('project_module_id',$value->id)->first();
      if($UserTypePrivilege) {
        $return ='Yes';
      } else {
        $return ='No';
      }
      return $return;
    })
    ->addColumn('action', function($value) use($UserType){
      $UserTypePrivilege=UserTypePrivilege::where('user_type_id',$UserType->id)->where('project_module_id',$value->id)->first();
      if($UserTypePrivilege) {
        $return='<input user_type_id="'.$UserType->id.'" project_module_id="'.$value->id.'" type="checkbox" class="js-switch user_type_privilage_change" checked />';
      } else {
        $return='<input user_type_id="'.$UserType->id.'" project_module_id="'.$value->id.'" type="checkbox" class="js-switch user_type_privilage_change" />';
      }
      return $return;
    })
    ->rawColumns(['action','color'])
    ->make(true);
  }
  public function Privilages_change_ajax(Request $request) {
    DB::beginTransaction();
    $user_type_id=$request['user_type_id'];
    $project_module_id=$request['project_module_id'];
    $data=array(
      'user_type_id'=>$user_type_id,
      'project_module_id'=>$project_module_id,
    );
    try {
      $UserTypePrivilege=UserTypePrivilege::where('user_type_id',$user_type_id)->where('project_module_id',$project_module_id)->first();
      if($UserTypePrivilege)
      {
        $UserTypePrivilege->delete();
      }
      else
      {
        $UserTypePrivilege_test=new UserTypePrivilege;
        $validator = Validator::make($data,$UserTypePrivilege_test->rules);
        if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
        
        UserTypePrivilege::create($data);
      }
      DB::commit();
      $return['result']='success';
    } catch (Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessages();
    }
    return response()->json($return);
  }
  public function UserTypes() {
    return view('users.user_types');
  }
  public function UserType_Table_ajax(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='name';
    $column[]='id';
    $limit=$request->input('length');
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    if($request->input('search.value')) {
      $search=$request->input('search.value');
      $datas=UserType::where('name' ,'like',"%{$search}%");
      $datas->offset($start);
      $datas->limit($limit);
      $datas->orderBy($order,$dir);
      $datas=$datas->get();
    } else {
      $datas=UserType::offset($start);
      $datas->limit($limit);
      $datas->orderBy($order,$dir);
      $datas=$datas->get();
    }
    return Datatables::of($datas)
    ->addIndexColumn()
    ->addColumn('action', function($value) use($request){
      $return ='';
      if(!$value->freeze) {
        $return ='<span><i table_id="'.$value->id.'" class="fa fa-2x fa-edit edit"></i></span>';
        $return.='<span class="pull-right"><i table_id="'.$value->id.'" class="fa fa-2x fa-trash-o delete"></i></span>';
        if($value->id==$request['table_id']) {
          $return ='<span><i table_id="'.$value->id.'" class="fa fa-2x fa-check ok_UserType"></i></span>';
          $nestedData['name']   ="<input value='".$value->name."' class='form-control' style='width:100%' id='edit_UserType_name'>";
        }
      }
      return $return;
    })
    ->addColumn('name', function($value) use($request){
      $return =$value->name;
      if(!$value->freeze) {
        if($value->id==$request['table_id']) {
          $return ="<input value='".$value->name."' class='form-control' style='width:100%' id='edit_UserType_name'>";
        }
      }
      return $return;
    })
    ->rawColumns(['action','name'])
    ->make(true);
  }
  public function UserType_store_ajax(Request $request) {
    try {
      $data=$request->all();
      $UserType=new UserType;
      $validator = Validator::make($data,$UserType->rules);
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
      $UserType=UserType::create($data);
      $return['result']='success';
    } catch (Exception $e) {
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  public function get_UserType_ajax($id) {
    $UserType=UserType::find($id);
    return response()->json($UserType);
  }
  public function UserType_update_ajax(Request $request, $id) {
    DB::beginTransaction();
    try {
      $UserType=UserType::find($id);
      $data=$request->all();
      $rules = [
        'name' =>'required|unique:user_types,name,'.$id,
      ];
      $test=new UserType;
      $validator = Validator::make($data,$rules);
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
      $UserType->name =$data['name'];
      $UserType->save();
      DB::commit();
      $return['result']='success';
    } catch (Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  public function UserType_destroy_ajax($id) {
    DB::beginTransaction();
    try {
      $UserType=UserType::find($id);
      $User=User::whereuser_type_id($id)->first();
      if($User) throw new Exception("Used In User Cant Delete", 1);
      $UserType->delete($id);
      $UserType = UserType::find($id);
      if(!$UserType)
      {
        DB::commit();
      }
      $return['result']='success';
    } catch (Exception $e) {
      $return['result']=$e->getMessage();
      DB::rollback();
    }
    return response()->json($return);
  }
  public function SendMail(Request $request) {
    try {
      $data=request()->all();
      $message=$data['message'];
      $MailController = new MailController;
      $return=$MailController->SendMail($data);
      if($return['result']!='success') throw new Exception($return['result']);
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();
    }
    return back()->withInput()->with($return['result']);
  }
  public function PasswordChange($user_id) {
    return view('users.passwordReset')->with('user_id',$user_id);
  }
  public function PasswordReset(Request $request,$id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $rules = [
        'password'             =>'required|min:6|same:password',
        'password_confirmation'=>'required|min:6|same:password',
      ];
      $test=new User;
      $validator = Validator::make($data,$rules);
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
      $User=User::find($id);
      if($data['password']!=$data['password_confirmation']) throw new Exception("Password Does not Match", 1);
      $User->password=$data['password'];
      $User->save();
      Auth::login($User);
      DB::commit();
      $return['result']='success';
    } catch (Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
      return back()->withInput()->withErrors($return['result']);
    }
    return redirect('/');
  }
  public function check_email_exists(Request $request) {
    $return='Not Exist';
    $data=$request->all();
    $User=User::whereemail($data['email'])->first();
    if($User){
      if(isset($data['lostpassword'])){
        $return=true;
      }
      if(isset($data['register'])){
        $return='Already Exist';
      }
    } else {
      if(isset($data['register'])){
        $return=true;
      }
    }
    return response()->json($return);
  }
  public function ForgotPasswordMail(Request $request) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $User=User::whereemail($data['email'])->first();
      $MailController = new MailController;
      $return=$MailController->PasswordRecoveryMail($User);
      if($return['result']!='success') throw new Exception($return['result']);
      $return['result']='success';
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      return back()->withInput()->withErrors($e->getMessage());
    }
    toastr()->success('Please Check Your Email','Result');
    return redirect('/SignIn');
  }
  public function UpdateUserPasswordById(Request $request,$id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $User=User::find($id);
      $User->password=$data['password'];
      $User->save();
      $return['result']='success';
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      return back()->withInput()->withErrors($e->getMessage());
    }
    toastr()->success('Password Updated SuccessFully','Result');
    return back();
  }
}
