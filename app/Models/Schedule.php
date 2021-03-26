<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Schedule extends Model
{
  use HasFactory;
  protected $fillable = [
    'employee_id',
    'date',
    'time',
    'remarks',
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'employee_id'=> 'required',
      'date'       => 'required',
      'time'       => 'required',
    ],
    $merge);
  }
  public function Employee() {
    return $this->belongsTo(Employee::class,'employee_id');
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
      if(!$Self->delete()) throw new \Exception("Cant Delete This Schedule ". $id, 1);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
}
