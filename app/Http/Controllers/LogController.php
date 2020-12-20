<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Validator;
use Response;
use DB;
use Form;
use Session;
use PDF;
use App;
use App\Models\Log;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
class LogController extends Controller
{
  public function Log() {
    $TableName='Log';
    return view('Log.index',compact('TableName'));
  }
  public function LogTable(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='date';
    $column[]='cordinator_id';
    $column[]='entry_time';
    $column[]='exit_time';
    $column[]='remarks';
    $column[]='id';
    $limit=$request->input('length');
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    $totalData = Log::count();
    $totalFiltered = $totalData;
    $datas=Log::orderBy('id');
    if($request['cordinator_id']) $datas->wherecordinator_id($request['cordinator_id']);
    if($request['from_date']) $datas->where('date','>=',date('Y-m-d',strtotime($request['from_date'])));
    if($request['to_date']) $datas->where('date','<=',date('Y-m-d',strtotime($request['to_date'])));
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
      $single['date'] =date("d-m-Y",strtotime($value->date));
      $single['Cordinator'] =$value->Cordinator->name;
      $single['action'] ='<div class="col-md-4"><i table_id="'.$value->id.'" class="fa fa-2x fa-edit edit"></i></div>';;
      $single['action'].='<div class="col-md-4"><a href="'.url('Log/Print/'.$value->id).'"><i class="fa fa-2x fa-print"></i></a></div>';
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
  public function Log_store_ajax(Request $request) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Log;
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
  public function Log_get_ajax($id) {
    $Log=Log::with('Cordinator')->find($id);
    return response()->json($Log);
  }
  public function Log_update_ajax(Request $request, $id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Log;
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
  public function Log_destroy_ajax($id) {
    try {
      DB::beginTransaction();
      $SelfModel=new Log;
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
  public function Log_Print($id) {
    $data=[];
    $Log=Log::find($id);
    $Cordinator=$Log->Cordinator->name;
    $Controller=$Log->Controller->name;
    $day=date('l',strtotime($Log->date));
    $date=date('d-m-Y',strtotime($Log->date));
    $html = <<<EOF
    <style>
    h1 {
      color: navy;
      font-family: times;
      font-size: 24pt;
      text-decoration: underline;
    }
    div.test {
      color: black;
      font-size: 10pt;
      border-style: solid solid solid solid;
      border-width: 1px 1px 0px 1px;
    }
    .lowercase {
      text-transform: lowercase;
    }
    .uppercase {
      text-transform: uppercase;
    }
    .capitalize {
      text-transform: capitalize;
    }
    </style>
    <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br />
    <div class="test">
    <table>
    <tr>
    <td colspan="2">COSPAS-SARSAT SYSTEM</td>
    </tr>
    <tr>
    <td colspan="2" align="Center"><h1>QAMCC - LOG SHEET</h1></td>
    </tr>
    <tr>
    <td>Day : $day</td>
    <td align="right">DATE : $date</td>
    </tr>
    </table>
    </div>
    <table border="1">
    <tr>
    <td align="center"> SAR COORDINATOR :</td>
    <td align="center"> Signature :</td>
    <td align="center" colspan="2"> Remark</td>
    </tr>
    <tr>
    <td style="height:70px;" align="center"> $Cordinator</td>
    <td style="height:70px;" align="center"> </td>
    <td style="height:70px;" colspan="2"> $Log->remarks </td>
    </tr>
    <tr>
    <td align="center" colspan="2"> Entry Time</td>
    <td align="center" colspan="2"> Exit Time</td>
    </tr>
    <tr>
    <td align="center" colspan="2">$Log->entry_time </td>
    <td align="center" colspan="2">$Log->exit_time </td>
    </tr>
    </table>
    <br />
    EOF;
    PDF::AddPage();
    PDF::Image(url('public/image/pdf_header.png'), '', '', 190, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
    PDF::writeHTML($html, true, false, true, false, '');
    PDF::Image(url('public/image/pdf_header.png'), '', 236, 190, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
    PDF::lastPage();
    PDF::Output('example_008.pdf', 'I');
  }
}
