<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App;
use Storage;
use Artisan;
use App\Models\Audit;
use App\Models\Document;
use App\Models\Beacon;
use Session;
use Config;
use Carbon\Carbon;
class HomeController extends Controller
{
  public function Home() {
    $Document=Document::orderBy('date_of_expiry')->whereBetween('date_of_expiry' ,[date('Y-m-d'),date('Y-m-d', strtotime("+30 days"))])->get();
    $ELTCount=Beacon::wherebeacon_type_id("ELT")->count();
    $EPIRBCount=Beacon::wherebeacon_type_id("EPIRB")->count();
    $PLBCount=Beacon::wherebeacon_type_id("PLB")->count();
    return view('home',compact('Document','ELTCount','EPIRBCount','PLBCount'));
  }
  public function EmptyPage() {
    return view('empty');
  }
  public function BackupDB() {
    Artisan::call('backup:run --only-db');
    return redirect()->back()->with('Bakuped the DB ', 'Success');
  }
  public function Download() {
    return view('database_backup');
  }
  public static function formatBytes($size, $precision = 2) {
    if ($size > 0) {
      $size = (int) $size;
      $base = log($size) / log(1024);
      $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
      return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    } else {
      return $size;
    }
  }
  public function BackupTable(Request $request) {
    $files=Storage::allFiles('/Laravel');
    $totalData=count($files);
    $totalFiltered=$totalData;
    $data=[];
    if($files) {
      foreach($files as $key=> $value) {
        $file=explode('/', $value);
        $nestedData['name']   =$file[1];
        $nestedData['size']   =$this->formatBytes(Storage::size($value));
        $nestedData['action'] ='<a href="'.url('getFile/'.$file[1]).'"><i class="fa fa-2x fa-download"></i></a>';
        $nestedData['action'].='<a class="pull-right" href="'.url('deleteFile/'.$file[1]).'"><i class="fa fa-2x fa-trash-o"></i></a>';
        $data[]=$nestedData;
      }
    }
    $json_data=array(
      "draw"           =>intval($request->input('draw')),
      "recordsTotal"   =>intval($totalData),
      "recordsFiltered"=>intval($totalFiltered),
      "data"           =>$data,
    );
    echo json_encode($json_data); exit;
  }
  public function getFile($file) {
    return response()->download(storage_path('app/Laravel/'. $file));
  }
  public function deleteFile($file) {
    unlink(storage_path('app/Laravel/'.$file));
    return back();
  }
  public function lang($locale) {
    if (array_key_exists($locale, Config::get('languages'))) {
      Session::put('applocale', $locale);
    }
    return redirect()->back();
  }
}
