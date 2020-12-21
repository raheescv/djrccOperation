<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Beacon;
use DB;
use Exception;
use Illuminate\Support\Arr;
class BeaconController extends Controller
{
  public function Beacons() {
    $TableName='Beacon';
    $status=Beacon::NEWBEACON;
    return view('Beacon.Beacons',compact('TableName','status'));
  }
  public function TestBeacons() {
    $TableName='Beacon';
    $status=Beacon::TESTBEACON;
    return view('Beacon.Beacons',compact('TableName','status'));
  }
  public function BeaconTable(Request $request) {
    $column=[];
    $column[]='id';
    $column[]='hex_no';
    $column[]='beacon_type_id';
    $column[]='country_id';
    $column[]='security_question';
    $column[]='security_answer';
    $column[]='special_status';
    $column[]='description';
    $column[]='name';
    $column[]='address';
    $column[]='city';
    $column[]='state';
    $column[]='postal_code';
    $column[]='email';
    $column[]='telephone';
    $column[]='mobile';
    $column[]='vehicle_type_id';
    $column[]='manufacturer';
    $column[]='model_no';
    $column[]='c_s_type_approval_no';
    $column[]='activation_method';
    $column[]='beacon_home_device';
    $column[]='additional_information';
    $column[]='primary_name';
    $column[]='primary_address_line_1';
    $column[]='primary_address_line_2';
    $column[]='primary_phone_number_1';
    $column[]='primary_phone_number_2';
    $column[]='primary_phone_number_3';
    $column[]='primary_phone_number_4';
    $column[]='alternative_name';
    $column[]='alternative_address_line_1';
    $column[]='alternative_address_line_2';
    $column[]='alternative_phone_number_1';
    $column[]='alternative_phone_number_2';
    $column[]='alternative_phone_number_3';
    $column[]='alternative_phone_number_4';
    $column[]='id';
    $limit=$request->input('length');
    $start=$request->input('start');
    $order=$column[$request->input('order.0.column')];
    $dir=$request->input('order.0.dir');
    $data=[];
    $totalData = Beacon::wherestatus($request['status'])->count();
    $totalFiltered = $totalData;
    $datas=Beacon::wherestatus($request['status']);
    if($request['beacon_type_id']) $datas->wherebeacon_type_id($request['beacon_type_id']);
    if($request['special_status']) $datas->wherespecial_status($request['special_status']);
    if($request['country_id']) $datas->wherecountry_id($request['country_id']);
    if($request['vehicle_type_id']) $datas->wherevehicle_type_id($request['vehicle_type_id']);
    if($request['manufacturer']) $datas->wheremanufacturer($request['manufacturer']);
    if($request['activation_method']) $datas->whereactivation_method($request['activation_method']);
    if($request['beacon_home_device']) $datas->wherebeacon_home_device($request['beacon_home_device']);
    if($request['from_date'] && $request['to_date']) $datas->whereBetween('created_at',[$request['from_date'],$request['to_date']]);
    $datas->orderBy($order,$dir);
    if(!empty($request->input('search.value'))) {
      $search = $request->input('search.value');
      $datas->where(function ($query) use ($search) {
        $query->where('id' ,'like',"%{$search}%");
        $query->orWhere('hex_no','LIKE',"%{$search}%");
        $query->orWhere('beacon_type_id','LIKE',"%{$search}%");
        $query->orWhere('name','LIKE',"%{$search}%");
      });
    }
    $totalFiltered=$datas->count();
    $datas->offset($start);
    $datas->limit($limit);
    $datas=$datas->get();
    $data=[];
    foreach ($datas as $key => $value) {
      $single=$value->toArray();
      $link=url('/BeaconView/'.$value->id);
      $single['hex_no']='<div class="col-md-6"><a href="'.$link.'" target="_blank">'.$value->hex_no.'</a></div>';
      $single['status']=$value->StatusName;
      $single['action']='<div class="col-md-6"><i table_id="'.$value->id.'" class="fa fa-2x fa-trash-o delete"></i></div>';;
      $link=url('/Audit/Beacon/'.$value->id);
      $single['Audit']='<a href="'.$link.'" target="_blank"><i class="fa fa-2x fa-history"></i></a>';
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
  public function BeaconView($id) {
    $TableName='Beacon';
    $Self=Beacon::find($id);
    if(!$Self) return redirect('/Beacon');
    return view('Beacon.BeaconView',compact('TableName','Self'));
  }
  public function Beacon($id=null) {
    $TableName='Beacon';
    $status=Beacon::NEWBEACON;
    if($id){
      $Self=Beacon::find($id);
      if(!$Self) return redirect('/Beacon');
    } else {
      $SelfModel = new Beacon;
      $Self['id']='';
      foreach ($SelfModel->getFillable() as $key => $value) {
        $Self[$value]='';
      }
    }
    return view('Beacon.Beacon',compact('TableName','Self','status'));
  }
  public function TestBeacon($id=null) {
    $TableName='Beacon';
    $status=Beacon::TESTBEACON;
    if($id){
      $Self=Beacon::find($id);
      if(!$Self) return redirect('/TestBeacon');
    } else {
      $SelfModel = new Beacon;
      $Self['id']='';
      foreach ($SelfModel->getFillable() as $key => $value) {
        $Self[$value]='';
      }
    }
    return view('Beacon.Beacon',compact('TableName','Self','status'));
  }
  public function Beacon_store(Request $request) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Beacon;
      $return_function=$SelfModel->selfCreate($data);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
      return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
    if ($request->ajax() || $request->wantsJson()) {
      return response()->json($return);
    } else {
      if($return_function['status']==Beacon::TESTBEACON){
        return redirect('TestBeacon/'.$return_function['id'])->with('message', $return['result']);
      } else {
        return redirect('Beacon/'.$return_function['id'])->with('message', $return['result']);
      }
    }
  }
  public function Beacon_update(Request $request,$id) {
    DB::beginTransaction();
    try {
      $data=$request->all();
      $SelfModel=new Beacon;
      $return_function=$SelfModel->selfUpdate($data,$id);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      $return['result']=$e->getMessage();
      return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
    return redirect('BeaconView/'.$id)->with('message', $return['result']);
  }
  public function Beacon_destroy_ajax($id) {
    try {
      $SelfModel=new Beacon;
      $return_function=$SelfModel->selfDelete($id);
      if($return_function['result']!='success') throw new \Exception($return_function['result'], 1);
      $return['result']='success';
    } catch (Exception $e) {
      $return['result']=$e->getMessage();
    }
    return response()->json($return);
  }
  public function Beacon_get_list_ajax(Request $request) {
    try {
      $search=isset($request['search_tag'])?$request['search_tag']:'';
      $data=Beacon::orderBy('hex_no');
      if($search) $data->where('hex_no' ,'like',"%{$search}%");
      if($request['beacon_type_id']) $data->where('beacon_type_id',$request['beacon_type_id']);
      $data=$data->get(['hex_no as name','id'])->toArray();
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
}
