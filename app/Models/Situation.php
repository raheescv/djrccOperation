<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Situation extends Model
{
  use HasFactory;
  protected $fillable = [
    "beacon_id",
    "country_id",
    "registered",
    "opened_by",
    "closed_by",
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'beacon_id' => 'required',
      'country_id'=> 'required',
      'registered'=> 'required',
      'opened_by' => 'required',
      'closed_by' => 'required',
    ],
    $merge);
  }
  public function Beacon() {
    return $this->belongsTo(Beacon::class);
  }
  public function Country() {
    return $this->belongsTo(Country::class);
  }
  public function OpenedBy() {
    return $this->belongsTo(Employee::class,'opened_by');
  }
  public function ClosedBy() {
    return $this->belongsTo(Employee::class,'closed_by');
  }
  public function SituationDetails() {
    return $this->hasMany(SituationDetail::class,'situation_id');
  }
  public static function registeredOptions() {
    return [
      'Yes'=>'Yes',
      'No'=>'No',
      'C/S'=>'C/S',
      'MMSI'=>'MMSI',
    ];
  }
  public function selfCreate($data) {
    try {
      $validator = \Validator::make($data,$this->rules());
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new \Exception($value[0]); } }
      $Self=Self::create($data);
      $return['result']='success';
      $return['id']=$Self->id;
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
      $SituationDetailModel=new SituationDetail;
      foreach ($Self->SituationDetails as $key => $value) {
        $return_function=$SituationDetailModel->selfDelete($value->id);
        if($return_function['result']!='success') throw new \Exception($return_function, 1);
      }
      if(!$Self->delete()) throw new \Exception("Cant Delete This Situation ". $id, 1);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
}
