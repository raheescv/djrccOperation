<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CheckList extends Model
{
  use HasFactory;
  protected $fillable = [
    "time",
    "date",
    "sarp_data",
    "orbit_data",
    "ftp_link",
    "aftn_link",
    "amhs_link",
    "tele_fax",
    "printer",
    "ops_room_status",
    "leo_lut",
    "geo_lut",
    "employee_id",
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'time'       => 'required',
      'date'       => 'required',
      'employee_id'=> 'required',
    ],
    $merge);
  }
  public function Employee() {
    return $this->belongsTo(Employee::class);
  }
  public function selfCreate($data) {
    try {
      $validator = \Validator::make($data,$this->rules());
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new \Exception($value[0]); } }
      $Self=Self::create($data);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
  public function selfUpdate($data,$id) {
    try {
      $validator = \Validator::make($data,$this->rules($id));
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new \Exception($value[0]); } }
      $Self=Self::find($id);
      $Self->update($data);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
  public function selfDelete($id) {
    try {
      $Self=Self::find($id);
      if(!$Self->delete()) throw new \Exception("Cant Delete This Log ". $id, 1);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
}
