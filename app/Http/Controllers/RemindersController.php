<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Validator;
use Response;
use DB;
use Form;
use Session;
use App\Models\Reminder;
use Yajra\Datatables\Datatables;
class RemindersController extends Controller
{
	public function index() {
		return view('reminders.index');
	}
	public function index_ajax(Request $request) {
		$column=[];
		$column[]='id';
		$column[]='date';
		$column[]='date';
		$column[]='subject';
		$column[]='id';
		$limit=$request->input('length');
		$start=$request->input('start');
		$order=$column[$request->input('order.0.column')];
		$dir=$request->input('order.0.dir');
		$data=[];
		if($request->input('search.value')) {
			$search=$request->input('search.value');
			$datas=Reminder::where('subject' ,'like',"%{$search}%");
			$datas->offset($start);
			$datas->limit($limit);
			$datas->orderBy($order,$dir);
			$datas=$datas->get();
		} else {
			$datas=Reminder::offset($start);
			$datas->limit($limit);
			$datas->orderBy($order,$dir);
			$datas=$datas->get();
		}
		return Datatables::of($datas)
		->addIndexColumn()
		->addColumn('day', function($value){
			$return=$value->Day($value->date);
			return $return;
		})
		->addColumn('action', function($value){
			$return ='<span table_id="'.$value->id.'"><i class="fa fa-2x fa-trash-o delete"></i></span>';
			return $return;
		})
		->rawColumns(['action'])
		->make(true);
	}
	public function reminder_store_ajax(Request $request) {
		try {
			$data=$request->all();
			$Reminder=new Reminder;
			$validator = Validator::make($data,$Reminder->rules);
			if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new Exception($value[0]); } }
			$Reminder=Reminder::create($data);
			$return['result']='success';
		} catch (Exception $e) {
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}
	public function destroy_ajax($id) {
		try {
			$Reminder=Reminder::find($id);
			if(!$Reminder->delete($id)) throw new Exception("Cant Delete Reminder", 1);
			$return['result']='success';
		} catch (Exception $e) {
			$return['result']=$e->getMessage();
		}
		return response()->json($return);
	}
}
