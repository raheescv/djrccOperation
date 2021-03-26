<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class SituationDetail extends Model
{
  use HasFactory;
  protected $fillable = [
    "situation_id",
    "date",
    "time",
    "details",
    "initial",
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'situation_id'=> 'required',
      'date'        => 'required',
      'time'        => 'required',
      'details'     => 'required',
    ],
    $merge);
  }
  public function Situation() {
    return $this->belongsTo(Situation::class,'controller_id');
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
  public function selfDelete($id) {
    try {
      $Self=Self::find($id);
      if(!$Self->delete()) throw new \Exception("Cant Delete This SituationDetail ". $id, 1);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
}
