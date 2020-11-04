<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Log extends Model
{
  use HasFactory;
  protected $fillable = [
    "date",
    "cordinator_id",
    "controller_id",
    "remarks",
    "entry_time",
    "exit_time",
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'date'         => 'required',
      'cordinator_id'=> 'required',
      'controller_id'=> 'required',
      'remarks'      => 'required',
      'entry_time'   => 'required',
      'exit_time'    => 'required',
    ],
    $merge);
  }
  public function Controller() {
    return $this->belongsTo(Employee::class,'controller_id');
  }
  public function Cordinator() {
    return $this->belongsTo(Employee::class,'cordinator_id');
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
