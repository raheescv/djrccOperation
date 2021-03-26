<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Validator;
use Response;
use DB;
use Form;
use Session;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\DocumentType;
use App\Models\Document;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use PDF;
class EmployeeController extends Controller
{
  public function Employee() {
    $TableName='Employee';
    return view('Employee.Employee',compact('TableName'));
  }
  public function EmployeeTable(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='employee_code';
    $column[]='name';
    $column[]='name_arabic';
    $column[]='id';
    $limit=$request->input('length');
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    $datas=Employee::offset($start);
    $datas->offset($start);
    $datas->limit($limit);
    $datas->orderBy($order,$dir);
    if($request->input('search.value')) {
      $search=$request->input('search.value');
      $datas->where('name' ,'like',"%{$search}%");
      $datas->orwhere('employee_code' ,'like',"%{$search}%");
      $datas->orwhere('name_arabic' ,'like',"%{$search}%");
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
  public function Employee_store_ajax(Request $request) {
    try {
      $data=$request->all();
      $SelfModel=new Employee;
      $return_function=$SelfModel->selfCreate($data);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
      $return['key']=$return_function['id'];
      $return['value']=$return_function['name'];
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  public function Employee_get_ajax($id) {
    $Employee=Employee::find($id);
    return response()->json($Employee);
  }
  public function Employee_update_ajax(Request $request, $id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Employee;
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
  public function Employee_destroy_ajax($id) {
    try {
      DB::beginTransaction();
      $SelfModel=new Employee;
      $return_function=$SelfModel->selfDelete($id);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
      DB::commit();
    } catch (Exception $e) {
      $return['result']=$e->getMessage();
      DB::rollback();
    }
    return response()->json($return);
  }
  public function Employee_get_list_ajax(Request $request) {
    try {
      $search=isset($request['search_tag'])?$request['search_tag']:'';
      $data=Employee::orderBy('name');
      if($search) $data->where('name' ,'like',"%{$search}%");
      $data=$data->get(['name','id'])->toArray();
      $prepend['id']=0; $prepend['name']='All';
      $data=Arr::prepend($data,$prepend);
      $single['id']='Add'; $single['name']='---- Add New ----';
      if(!isset($request['type'])) $data[]=$single;
      $return['items'] = $data;
    } catch (Exception $e) {
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  public function Employee_employee_code_check(Request $request) {
    $return='Not Exist';
    $data=$request->all();
    $Model=Employee::whereemployee_code($data['employee_code'])->first();
    if($Model){
      $return='Already Exist';
    } else {
      $return=true;
    }
    return response()->json($return);
  }
  
  public function Document() {
    $TableName='Document';
    return view('Employee.Document',compact('TableName'));
  }
  public function DocumentTable(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='employee_id';
    $column[]='document_type_id';
    $column[]='date_of_issue';
    $column[]='date_of_issue';
    $column[]='date_of_expiry';
    $column[]='date_of_expiry';
    $column[]='id';
    $limit=$request->input('length');
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    $datas=Document::offset($start);
    $datas->offset($start);
    $datas->limit($limit);
    $datas->orderBy($order,$dir);
    if($request->input('search.value')) {
      $search=$request->input('search.value');
      $datas->where('employee_id' ,'like',"%{$search}%");
      $datas->orwhere('date_of_expiry' ,'like',"%{$search}%");
      $datas->orwhere('date_of_issue' ,'like',"%{$search}%");
    }
    if($request['employee_id']) $datas->whereemployee_id($request['employee_id']);
    if($request['document_type_id']) $datas->wheredocument_type_id($request['document_type_id']);
    $datas=$datas->get();
    return Datatables::of($datas)
    ->addIndexColumn()
    ->addColumn('date_of_issue', function($value) use($request){
      $return=date('d-m-Y',strtotime($value->date_of_issue));
      if($value->id==$request['table_id']) {
        $return='<input class="form-control" id="edit_Document_date_of_issue" type="date" style="width:100%" value="'.$value->date_of_issue.'">';
      }
      return $return;
    })
    ->addColumn('date_of_expiry', function($value) use($request){
      $return=date('d-m-Y',strtotime($value->date_of_expiry));
      if($value->id==$request['table_id']) {
        $return='<input class="form-control" id="edit_Document_date_of_expiry" type="date" style="width:100%" value="'.$value->date_of_expiry.'">';
      }
      return $return;
    })
    ->addColumn('Remaining', function($value){ return $value->Remaining(); })
    ->addColumn('Duration', function($value){ return $value->Duration(); })
    ->addColumn('Employee', function($value){ return $value->Employee->name; })
    ->addColumn('DocumentType', function($value){ return $value->DocumentType->name; })
    ->addColumn('action', function($value) use($request) {
      $return ='<span class="pull-left" ><i table_id="'.$value->id.'" class="fa fa-2x fa-edit edit"></i></span>';
      if($value->id==$request['table_id']) {
        $return ='<span><i table_id="'.$value->id.'" class="fa fa-2x fa-check ok_Document"></i></span>';
      }
      $return.='<span class="pull-right"><i table_id="'.$value->id.'" class="fa fa-2x fa-trash-o delete"></i></span>';
      return $return;
    })
    ->rawColumns(['action','date_of_issue','date_of_expiry'])
    ->make(true);
  }
  public function Document_store_ajax(Request $request) {
    try {
      $data=$request->all();
      $SelfModel=new Document;
      $return_function=$SelfModel->selfCreate($data);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
    } catch (Exception $e) {
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  public function Document_get_ajax($id) {
    $Document=Document::find($id);
    return response()->json($Document);
  }
  public function Document_update_ajax(Request $request, $id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Document;
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
  public function Document_destroy_ajax($id) {
    try {
      $SelfModel=new Document;
      $return_function=$SelfModel->selfDelete($id);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
    } catch (Exception $e) {
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  
  public function Schedule() {
    $TableName='Schedule';
    return view('Employee.Schedule',compact('TableName'));
  }
  public function ScheduleTable(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='employee_id';
    $column[]='date';
    $column[]='time';
    $column[]='remarks';
    $column[]='id';
    $limit=$request->input('length');
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    $totalData = Schedule::count();
    $totalFiltered = $totalData;
    $datas=Schedule::orderBy('id');
    if($request['employee_id']) $datas->whereemployee_id($request['employee_id']);
    if($request['from_date']) $datas->where('date','>=',date('Y-m-d',strtotime($request['from_date'])));
    if($request['to_date']) $datas->where('date','<=',date('Y-m-d',strtotime($request['to_date'])));
    
    if($request['from_time']) $datas->where('time','>=',date('H:i:s',strtotime($request['from_time'])));
    if($request['to_time']) $datas->where('time','<=',date('H:i:s',strtotime($request['to_time'])));
    
    $datas->orderBy($order,$dir);
    if(!empty($request->input('search.value'))) {
      $search = $request->input('search.value');
      $datas->where(function ($query) use ($search) {
        $query->where('id' ,'like',"%{$search}%");
        $query->orWhere('remarks','LIKE',"%{$search}%");
      });
    }
    $totalFiltered=$datas->count();
    $datas->offset($start);
    $datas->limit($limit);
    $datas=$datas->get();
    $data=[];
    foreach ($datas as $key => $value) {
      $single=$value->toArray();
      $single['time'] =date("H:i A",strtotime($value->time));
      $single['date'] =date("d-m-Y",strtotime($value->date));
      $single['Employee'] =$value->Employee->name;
      $single['action'] ='<div class="col-md-4"><i table_id="'.$value->id.'" class="fa fa-2x fa-edit edit"></i></div>';;
      // $single['action'].='<div class="col-md-4"><a href="'.url('Schedule/Print/'.$value->id).'"><i class="fa fa-2x fa-print"></i></a></div>';
      $single['action'].='<div class="col-md-4"><i table_id="'.$value->id.'" class="fa fa-2x fa-trash-o delete"></i></div>';;
      $data[]=$single;
    }
    $json_data = array(
      "draw"            => intval($request->input('draw')),
      "recordsTotal"    => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data"            => $data
    );
    echo json_encode($json_data); exit;
  }
  public function Schedule_store_ajax(Request $request) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Schedule;
      $return_function=$SelfModel->selfCreate($data);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  public function Schedule_get_ajax($id) {
    $Schedule=Schedule::with('Employee')->find($id);
    return response()->json($Schedule);
  }
  public function Schedule_update_ajax(Request $request, $id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Schedule;
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
  public function Schedule_destroy_ajax($id) {
    try {
      DB::beginTransaction();
      $SelfModel=new Schedule;
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
  
  public function Schedule_Print($id) {
    $data=[];
    $id=explode(',',$id);
    $Schedule=Schedule::whereIn('id',$id)->get();
    $day=date('D',strtotime($Schedule[0]->date));
    $date=date('d-m-Y',strtotime($Schedule[0]->date));
    $html = <<<EOF
    <style>
    h1 {
      color: navy;
      font-family: times;
      font-size: 24pt;
    }
    </style>
    <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br />
    <table>
    <tr>
    <td><h1 align="center">SCHEDULE REPORT</h1></td>
    </tr>
    </table>
    <br />
    EOF;
    PDF::AddPage();
    PDF::Image(url('public/image/pdf_header.png'), '', '', 190, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
    PDF::writeHTML($html, true, false, true, false, '');
    $tbody='';
    foreach ($Schedule as $key => $value) {
      $date=date('d-m-Y',strtotime($value->date));
      $time=date('H:i a',strtotime($value->time));
      $tbody.='<tr nobsr="true">';
      $tbody.='<td style="width:45%"> '.$value->Employee->name.'</td>';
      $tbody.='<td style="width:15%"> '.$date.'</td>';
      $tbody.='<td style="width:10%"> '.$time.'</td>';
      $tbody.='<td style="width:30%"> '.$value->remarks.'</td>';
      $tbody.="</tr>";
    }
    $html = <<<EOF
    <style>
    .center {
      margin-left: auto;
      margin-right: auto;
    }
    </style>
    <table border="1" class='center'>
    <thead align='center'>
    <tr>
    <th style="width:45%; text-align: center; vertical-align: middle;">Name</th>
    <th style="width:15%; text-align: center; vertical-align: middle;">Date</th>
    <th style="width:10%; text-align: center; vertical-align: middle;">Time</th>
    <th style="width:30%; text-align: center; vertical-align: middle;">Signature</th>
    </tr>
    </thead>
    <tbody align="center">
    $tbody
    <tbody>
    </table>
    <br />
    EOF;
    // PDF::SetAutoPageBreak(TRUE, 50);
    PDF::writeHTML($html, true, false, true, false, '');
    PDF::lastPage();
    PDF::Output('Shedule.pdf', 'I');
  }
}
