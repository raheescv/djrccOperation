<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Country extends Model
{
  use SoftDeletes;
  use HasFactory;
  protected $fillable = [
    'name',
    'code',
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'name'=> 'required|unique:countries'. ($id ? ",name,$id" : ''),
      'code'=> 'required|unique:countries'. ($id ? ",code,$id" : ''),
    ],
    $merge);
  }
  public function Beacons() {
    return $this->hasMany(Beacon::class,'country_id');
  }
  public static function countryOptions() {
    return Self::pluck('name','id')->toArray();
  }
  public function selfCreate($data) {
    try {
      $Self=Self::onlyTrashed()->wherename($data['name'])->first();
      if(!$Self){
        $validator = \Validator::make($data,$this->rules());
        if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new \Exception($value[0]); } }
        $Self=Self::create($data);
      } else {
        $Model->restore();
        $id=$Self->id;
        $validator = \Validator::make($data,$this->rules($id));
        if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new \Exception($value[0]); } }
        $Self->update($data);
      }
      $return['result']='success';
      $return['id']=$Self->id;
      $return['name']=$Self->name;
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
      if(!empty($Self->Beacons->toArray())) throw new \Exception("Used in Beacons", 1);
      if(!$Self->delete()) throw new \Exception("Cant Delete This Employee". $id, 1);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
}
