<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Situation;
use App\Models\Views\SituationView;
use App\Models\SituationDetail;
use DB;
use Exception;
use PDF;
class SituationController extends Controller
{
  public function Situations() {
    $TableName='Situation';
    return view('Situation.list',compact('TableName'));
  }
  public function Situation($id=null) {
    $TableName='Situation';
    $Beacon=[];
    $OpenedBy=[];
    $ClosedBy=[];
    if($id){
      $Self=Situation::find($id);
      if(!$Self) return redirect('/Situations');
      $Self['beacon_type_id']=$Self->Beacon->beacon_type_id;
      $Beacon[$Self->beacon_id]=$Self->Beacon->hex_no;
      $ClosedBy[$Self->closed_by]=$Self->ClosedBy->name;
      $OpenedBy[$Self->opened_by]=$Self->OpenedBy->name;
    } else {
      $SelfModel = new Situation;
      $Self['beacon_type_id']='';
      $Self['id']='';
      foreach ($SelfModel->getFillable() as $key => $value) {
        $Self[$value]='';
      }
    }
    return view('Situation.Situation',compact('TableName','Self','OpenedBy','ClosedBy','Beacon'));
  }
  public function SituationTable(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='beacon_type_id';
    $column[]='Beacon';
    $column[]='Country';
    $column[]='registered';
    $column[]='OpenedBy';
    $column[]='ClosedBy';
    $column[]='id';
    $limit=$request->input('length');
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    $totalData = SituationView::count();
    $totalFiltered = $totalData;
    $datas=SituationView::orderBy($order,$dir);
    if($request['beacon_type_id']) $datas->wherebeacon_type_id($request['beacon_type_id']);
    if($request['beacon_id']) $datas->wherebeacon_id($request['beacon_id']);
    if($request['country_id']) $datas->wherecountry_id($request['country_id']);
    if($request['opened_by']) $datas->whereopened_by($request['opened_by']);
    if($request['closed_by']) $datas->whereclosed_by($request['closed_by']);
    if(!empty($request->input('search.value'))) {
      $search = $request->input('search.value');
      $datas->where(function ($query) use ($search) {
        $query->where('registered' ,'like',"%{$search}%");
      });
    }
    $totalFiltered=$datas->count();
    $datas->offset($start);
    $datas->limit($limit);
    $datas=$datas->get();
    $data=[];
    foreach ($datas as $key => $value) {
      $single=$value->toArray();
      $single['action'] ='<div class="col-md-4"><a href="'.url('Situation/'.$value->id).'"><i class="fa fa-2x fa-eye"></i></a></div>';
      $single['action'].='<div class="col-md-4"><a href="'.url('Situation/Print/'.$value->id).'"><i class="fa fa-2x fa-print"></i></a></div>';
      $single['action'].='<div class="col-md-4"><i table_id="'.$value->id.'" class="fa fa-2x fa-trash-o delete"></i></div>';
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
  public function Situation_store(Request $request) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Situation;
      $return_function=$SelfModel->selfCreate($data);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
      return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
    return redirect('Situation/'.$return_function['id'])->with('message', $return['result']);
  }
  public function Situation_update(Request $request,$id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Situation;
      $return_function=$SelfModel->selfUpdate($data,$id);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
      return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
    return redirect('Situation/'.$id)->with('message', $return['result']);
  }
  public function Situation_destroy_ajax($id) {
    try {
      $SelfModel=new Situation;
      $return_function=$SelfModel->selfDelete($id);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
    } catch (Exception $e) {
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  
  public function SituationDetailTable(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='date';
    $column[]='time';
    $column[]='details';
    $column[]='initial';
    $column[]='id';
    $data=[];
    $totalData = SituationDetail::count();
    $totalFiltered = $totalData;
    $datas=SituationDetail::with('Situation');
    if($request['situation_id']) $datas->wheresituation_id($request['situation_id']);
    if(!empty($request->input('search.value'))) {
      $search = $request->input('search.value');
      $datas->where(function ($query) use ($search) {
        $query->where('id' ,'like',"%{$search}%");
        $query->orWhere('details','LIKE',"%{$search}%");
        $query->orWhere('initial','LIKE',"%{$search}%");
      });
    }
    $datas=$datas->get();
    $data=[];
    foreach ($datas as $key => $value) {
      $single=$value->toArray();
      $key++;
      $single['key'] =$key;
      $single['date'] =date("d-m-Y",strtotime($value->date));
      $single['time'] =date("h:i A",strtotime($value->time));
      $single['action'] ='<div class="col-md-6"><i table_id="'.$value->id.'" class="fa fa-2x fa-trash-o delete"></i></div>';;
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
  public function SituationDetail_store_ajax(Request $request) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new SituationDetail;
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
  public function SituationDetail_destroy_ajax($id) {
    try {
      DB::beginTransaction();
      $SelfModel=new SituationDetail;
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
  
  public function Situation_Print($id) {
    $data=[];
    $Situation=Situation::find($id);
    $type=$Situation->Beacon->beacon_type_id;
    $Beacon=$Situation->Beacon->hex_no;
    $OpenedBy=$Situation->OpenedBy->name;
    $ClosedBy=$Situation->ClosedBy->name;
    $Country=$Situation->Country->name;
    $CountryCode=$Situation->Country->code;
    $day=date('D',strtotime($Situation->date));
    $date=date('d-m-Y',strtotime($Situation->date));
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
    <td><h1 align="center">SITATUIN REPORT (SITREP) </h1></td>
    </tr>
    </table>
    <table border="1">
    <tr>
    <td style="height:20px;" align="center"> BEACON TYPE :</td>
    <td style="height:20px;" colspan="3"> $type</td>
    </tr>
    <tr>
    <td style="height:20px;" align="center"> HEXA CODE 15 :</td>
    <td style="height:20px;" colspan="3"> $Beacon</td>
    </tr>
    <tr>
    <td style="height:20px;" align="center"> COUNTRY/CODE :</td>
    <td style="height:20px;" colspan="3"> $Country/$CountryCode</td>
    </tr>
    <tr>
    <td style="height:20px;" align="center"> REGISTERD :</td>
    <td style="height:20px;" colspan="3"> $Situation->registered</td>
    </tr>
    <tr>
    <td  style="height:40px;" align="center"> OPENED BY :</td>
    <td  style="height:40px;" align="center">$OpenedBy</td>
    <td  style="height:40px;" colspan="2"></td>
    </tr>
    <tr>
    <td  style="height:40px;" align="center"> CLOSED BY :</td>
    <td  style="height:40px;" align="center">$ClosedBy</td>
    <td  style="height:40px;" colspan="2"></td>
    </tr>
    </table>
    <br />
    EOF;
    PDF::AddPage();
    PDF::Image(url('public/image/pdf_header.png'), '', '', 190, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
    PDF::writeHTML($html, true, false, true, false, '');
    $tbody='';
    foreach ($Situation->SituationDetails as $key => $value) {
      $date=date('d-m-Y',strtotime($value->date));
      $tbody.='<tr nobsr="true">';
      $tbody.='<td style="width:15%"> '.$date.'</td>';
      $tbody.='<td style="width:10%"> '.date('H:i',strtotime($value->time)).'</td>';
      $tbody.='<td style="width:60%"> '.$value->details.'</td>';
      $tbody.='<td style="width:15%"> '.$value->initial.'</td>';
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
    <th style="width:15%; text-align: center; vertical-align: middle;">DATE</th>
    <th style="width:10%; text-align: center; vertical-align: middle;">TIME</th>
    <th style="width:60%; text-align: center; vertical-align: middle;">DETAILS</th>
    <th style="width:15%; text-align: center; vertical-align: middle;">INITIAL</th>
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
    PDF::Output('situation.pdf', 'I');
  }
}
