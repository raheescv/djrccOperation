<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Validator;
use Response;
use DB;
use Form;
use Session;
use App\Models\Settings;
use App\Models\Employee;
use App\Models\DocumentType;
use App\Models\Country;
use App\Models\Document;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
class SettingsController extends Controller
{
	public function Settings() {
		$skins=[
			'skin-0'=>'Default skin',
			'skin-1'=>'Blue skin',
			'skin-2'=>'Inspinia ultra skin',
			'skin-3'=>'Yellow skin',
			'md-skin'=>'Inspania Skin',
		];
		return view('settings.settings')
		->with('skins',$skins)
		;
	}
	public function Settings_Update(Request $request) {
		try {
			$data=$request->all();
			$Settings=new Settings;
			if(!isset($data['fixed_nav_bar'])) $data['fixed_nav_bar']='No';
			if(!isset($data['fixed_side_bar'])) $data['fixed_side_bar']='No';
			if(!isset($data['fixed_footer'])) $data['fixed_footer']='No';
			if(!isset($data['collapse_menu'])) $data['collapse_menu']='No';
			$validator = Validator::make($data,$Settings->rules);
			if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
			$Settings=Settings::first();
			$Settings->update($data);
			$return['result']='success';
			return redirect()->back()->with('message', 'Success');
		} catch (Exception $e) {
			$return['result']=$e->getMessage();
			return redirect()->back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function DocumentType() {
		$TableName='DocumentType';
		return view('settings.DocumentType',compact('TableName'));
	}
	public function DocumentTypeTable(Request $request) {
		$column=[];
		$column[]='id';
		$column[]='name';
		$column[]='id';
		$limit=$request->input('length');
		$start=$request->input('start');
		$order=$column[$request->input('order.0.column')];
		$dir=$request->input('order.0.dir');
		$data=[];
		$datas=DocumentType::offset($start);
		$datas->offset($start);
		$datas->limit($limit);
		$datas->orderBy($order,$dir);
		if($request->input('search.value')) {
			$search=$request->input('search.value');
			$datas->where('name' ,'like',"%{$search}%");
		}
		$datas=$datas->get();
		return Datatables::of($datas)
		->addIndexColumn()
		->addColumn('action', function($value){
			$return ='<span class="pull-left" ><i table_id="'.$value->id.'" class="fa fa-2x fa-edit edit"></i></span>';
			$return.='<span class="pull-right"><i table_id="'.$value->id.'" class="fa fa-2x fa-trash-o delete"></i></span>';
			return $return;
		})
		->rawColumns(['action'])
		->make(true);
	}
	public function DocumentType_store_ajax(Request $request) {
		DB::beginTransaction();
		try {
			$data=$request->all();
			$SelfModel=new DocumentType;
			$return_function=$SelfModel->selfCreate($data);
			if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
			$return['result']='success';
			$return['key']=$return_function['id'];
			$return['value']=$return_function['name'];
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}
	public function DocumentType_get_ajax($id) {
		$DocumentType=DocumentType::find($id);
		return response()->json($DocumentType);
	}
	public function DocumentType_update_ajax(Request $request, $id) {
		DB::beginTransaction();
		try {
			$data=$request->all();
			$SelfModel=new DocumentType;
			$return_function=$SelfModel->selfUpdate($data,$id);
			if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
			DB::commit();
			$return['result']='success';
		} catch (Exception $e) {
			DB::rollback();
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}
	public function DocumentType_destroy_ajax($id) {
		try {
			DB::beginTransaction();
			$SelfModel=new DocumentType;
			$return_function=$SelfModel->selfDelete($id);
			if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
			$return['result']='success';
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}
	public function DocumentType_get_list_ajax(Request $request) {
		try {
			$search=isset($request['search_tag'])?$request['search_tag']:'';
			$data=DocumentType::orderBy('name');
			if($search) $data->where('name' ,'like',"%{$search}%");
			$data=$data->get(['name','id'])->toArray();
			$prepend['id']=0; $prepend['name']='All';
			$data=Arr::prepend($data,$prepend);
			$single['id']='Add'; $single['name']='---- Add New ----';
			$data[]=$single;
			$return['items'] = $data;
		} catch (Exception $e) {
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}

	public function Country() {
		$TableName='Country';
		return view('settings.Country',compact('TableName'));
	}
	public function CountryTable(Request $request) {
		$column=[];
		$column[]='id';
		$column[]='name';
		$column[]='id';
		$limit=$request->input('length');
		$start=$request->input('start');
		$order=$column[$request->input('order.0.column')];
		$dir=$request->input('order.0.dir');
		$data=[];
		$datas=Country::offset($start);
		$datas->offset($start);
		$datas->limit($limit);
		$datas->orderBy($order,$dir);
		if($request->input('search.value')) {
			$search=$request->input('search.value');
			$datas->where('name' ,'like',"%{$search}%");
		}
		$datas=$datas->get();
		return Datatables::of($datas)
		->addIndexColumn()
		->addColumn('action', function($value){
			$return ='<span class="pull-left" ><i table_id="'.$value->id.'" class="fa fa-2x fa-edit edit"></i></span>';
			$return.='<span class="pull-right"><i table_id="'.$value->id.'" class="fa fa-2x fa-trash-o delete"></i></span>';
			return $return;
		})
		->rawColumns(['action'])
		->make(true);
	}
	public function Country_store_ajax(Request $request) {
		DB::beginTransaction();
		try {
			$data=$request->all();
			$SelfModel=new Country;
			$return_function=$SelfModel->selfCreate($data);
			if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
			$return['result']='success';
			$return['key']=$return_function['id'];
			$return['value']=$return_function['name'];
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}
	public function Country_get_ajax($id) {
		$Country=Country::find($id);
		return response()->json($Country);
	}
	public function Country_update_ajax(Request $request, $id) {
		DB::beginTransaction();
		try {
			$data=$request->all();
			$SelfModel=new Country;
			$return_function=$SelfModel->selfUpdate($data,$id);
			if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
			DB::commit();
			$return['result']='success';
		} catch (Exception $e) {
			DB::rollback();
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}
	public function Country_destroy_ajax($id) {
		try {
			DB::beginTransaction();
			$SelfModel=new Country;
			$return_function=$SelfModel->selfDelete($id);
			if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
			$return['result']='success';
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}
	public function Country_get_list_ajax(Request $request) {
		try {
			$search=isset($request['search_tag'])?$request['search_tag']:'';
			$data=Country::orderBy('name');
			if($search) $data->where('name' ,'like',"%{$search}%");
			$data=$data->get(['name','id'])->toArray();
			$prepend['id']=0; $prepend['name']='All';
			$data=Arr::prepend($data,$prepend);
			$single['id']='Add'; $single['name']='---- Add New ----';
			$data[]=$single;
			$return['items'] = $data;
		} catch (Exception $e) {
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}
}
