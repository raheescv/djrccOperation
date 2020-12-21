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
use App\Models\CheckList;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
class CheckListController extends Controller
{
  public function CheckList() {
    $TableName='CheckList';
    return view('CheckList.index',compact('TableName'));
  }
  public function CheckListTable(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='time';
    $column[]='date';
    $column[]='sarp_data';
    $column[]='orbit_data';
    $column[]='ftp_link';
    $column[]='aftn_link';
    $column[]='amhs_link';
    $column[]='tele_fax';
    $column[]='printer';
    $column[]='ops_room_status';
    $column[]='leo_lut';
    $column[]='geo_lut';
    $column[]='employee_id';
    $column[]='id';
    $limit=$request->input('length');
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    $totalData = CheckList::count();
    $totalFiltered = $totalData;
    $datas=CheckList::orderBy('id');
    if($request['cordinator_id']) $datas->wherecordinator_id($request['cordinator_id']);
    if($request['controller_id']) $datas->wherecontroller_id($request['controller_id']);
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
      $single['Employee'] =$value->Employee->name;
      $single['action'] ='<div class="col-md-4"><i table_id="'.$value->id.'" class="fa fa-2x fa-edit edit"></i></div>';;
      $single['action'].='<div class="col-md-4"><a href="'.url('CheckList/Print/'.$value->id).'"><i class="fa fa-2x fa-print"></i></a></div>';
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
  public function CheckList_store_ajax(Request $request) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new CheckList;
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
  public function CheckList_get_ajax($id) {
    $CheckList=CheckList::with('Employee')->find($id);
    return response()->json($CheckList);
  }
  public function CheckList_update_ajax(Request $request, $id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new CheckList;
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
  public function CheckList_destroy_ajax($id) {
    try {
      DB::beginTransaction();
      $SelfModel=new CheckList;
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
  public function CheckList_Print($id) {
    $data=[];
    $CheckList=CheckList::find($id);
    $Employee=$CheckList->Employee->name;
    $day=date('l',strtotime($CheckList->date));
    $date=date('d-m-Y',strtotime($CheckList->date));
    $date=date('d-m-Y',strtotime($CheckList->date));
    $html = <<<EOF
    <style>
    h2 {
      color: navy;
      font-family: times;
      font-size: 20pt;
      text-decoration: underline;
    }
    div.test {
      color: black;
      font-size: 10pt;
      border-style: solid solid solid solid;
      border-width: 1px 1px 0px 1px;
    }
    th{
      text-transform: uppercase;
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
    <table>
    <tr>
    <td align="Center"> <h2>QAMCC</h2></td>
    </tr>
    <tr>
    <td align="Center"> <h2>SYSTEM CHECK</h2></td>
    </tr>
    </table>
    <table border="1">
    <tr>
    <th align="center" colspan="4"> <b style="font-size: 15pt;">MCC STATUS</b> :</th>
    </tr>
    <tr>
    <th align="center"> TIME/DATE/DAY</th>
    <td align="center">$CheckList->time </td>
    <td align="center">$date </td>
    <td align="center">$day </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">SARP DATA</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->sarp_data </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">Orbit Data</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->orbit_data </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">ftp Link</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->ftp_link </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">aftn link</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->aftn_link </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">amhs link</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->amhs_link </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">tele fax</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->tele_fax </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">printer</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->printer </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">ops room status</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->ops_room_status </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">leo lut</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->leo_lut </td>
    </tr>
    <tr>
    <th style="height:20px;">  &nbsp; <span class="uppercase">geo lut</span></th>
    <td style="height:20px;" colspan="3"> $CheckList->geo_lut </td>
    </tr>
    <tr>
    <th style="height:50px;">  &nbsp; <span class="uppercase">Name/Sign</span></th>
    <td style="height:50px;" colspan="3"> $Employee </td>
    </tr>
    </table>
    <br />
    EOF;
    PDF::AddPage();
    PDF::Image(url('public/image/pdf_header.png'), '', '', 190, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
    PDF::writeHTML($html, true, false, true, false, '');
    PDF::lastPage();
    PDF::Output('example_008.pdf', 'I');
  }
}
