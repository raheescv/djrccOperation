<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Validator;
use Response;
use DB;
use Form;
use Session;
use App\Models\Task;
use Yajra\Datatables\Datatables;

class TasksController extends Controller
{
  public function index() {
    $calendar = Task::all();
    $Tasks    = Task::where('date','>=',date('Y-m-d'))->get();
    return view('tasks.index', compact('calendar','Tasks'));
  }
  public function Task_Table_ajax(Request $request) {
    $column=[];
    $column[]='tasks.id';
    $column[]='tasks.title';
    $column[]='tasks.description';
    $column[]='date';
    $column[]='start_time';
    $column[]='end_time';
    $column[]='color';
    $column[]='status';
    $column[]='tasks.id';
    $limit=$request->input('length');
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    if($request->input('search.value')) {
      $search=$request->input('search.value');
      $datas=Task::offset($start);
      if($request['from'] && $request['to']) $datas->whereBetween('date' ,[$request['from'],$request['to']]);
      $datas=$datas->where('tasks.id' , 'like',"%{$search}%")
      ->orwhere('tasks.title'         , 'like',"%{$search}%")
      ->orwhere('tasks.description'   , 'like',"%{$search}%")
      ->offset($start)->limit($limit)->orderBy($order,$dir)->get(['tasks.*']);
    } else {
      $datas=Task::offset($start);
      if($request['from'] && $request['to']) $datas->whereBetween('date' ,[$request['from'],$request['to']]);
      $datas=$datas->limit($limit)->orderBy($order,$dir)->get(['tasks.*']);
    }
    $statuses=['0'=>' ','1'=>'Pending','2'=>'Completed','3'=>'Cancel'];
    return Datatables::of($datas)
    ->addIndexColumn()
    ->addColumn('date', function($value){
      $return=date('d-m-Y',strtotime($value->date));
      return $return;
    })
    ->addColumn('start_time', function($value){
      $return=date('h:i A',strtotime($value->start_time));
      return $return;
    })
    ->addColumn('start_time', function($value){
      $return=date('h:i A',strtotime($value->start_time));
      return $return;
    })
    ->addColumn('status', function($value) use($statuses){
      $return=$statuses[$value->status];
      return $return;
    })
    ->addColumn('color', function($value) {
      $return='<span class="btn-colorselector" style="background-color: '.$value->color.';"></span>';
      return $return;
    })
    ->addColumn('action', function($value){
      $return ='<span><i table_id="'.$value->id.'" class="fa fa-2x fa-pencil edit"></i></span>';
      $return.='<span><i table_id="'.$value->id.'" class="fa fa-2x fa-trash-o delete pull-right"></i></span>';
      return $return;
    })
    ->rawColumns(['action','color'])
    ->make(true);
  }
  public function add_Task_ajax(Request $request) {
    try {
      $data=$request->all();
      $data['status']=1;
      $data['date']=date('Y-m-d',strtotime($data['date']));
      $data['start_time']=date('H:i',strtotime($data['start_time']));
      $data['end_time']=date('H:i',strtotime($data['end_time']));
      $Task=new Task;
      $validator = Validator::make($data,$Task->rules);
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
      $Task=Task::create($data);
      $return['result']='success';
    } catch (Exception $e) {
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  public function Tasks() {
    $Tasks = Task::where('date','>=',date('Y-m-d'))->get();
    return view('tasks.tasks', compact('Tasks'));
  }
  public function get_Task_ajax($id) {
    $Task=Task::find($id);
    $Task->start_time=date('H:i',strtotime($Task->start_time));
    $Task->end_time  =date('H:i',strtotime($Task->end_time));
    return response()->json($Task);
  }
  public function edit_Task_ajax(Request $request, $id) {
    DB::beginTransaction();
    try {
      $Task=Task::find($id);
      $data=$request->all();
      $test=new Task;
      $validator = Validator::make($data,$Task->rules);
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
      $Task->title          =$data['title'];
      $Task->description    =$data['description'];
      $Task->color          =$data['color'];
      $Task->date           =date('Y-m-d H:i:s',strtotime($data['date']));
      $Task->start_time     =date('Y-m-d H:i:s',strtotime($data['start_time']));
      $Task->end_time       =date('Y-m-d H:i:s',strtotime($data['end_time']));
      $Task->status         =$data['status'];
      $Task->save();
      DB::commit();
      $return['result']='success';
    } catch (Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  public function delete_Task_ajax($id) {
    DB::beginTransaction();
    try {
      $Task=Task::find($id);
      $Task->delete($id);
      $Task = Task::find($id);
      if(!$Task)
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
}
