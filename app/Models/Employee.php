<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;
class Employee extends Model implements AuditableContracts {
  use Auditable;
  use SoftDeletes;
  protected $fillable = [
    'name',
    'employee_code',
    'name_arabic',
  ];
  public $rules = [
    'name'         => 'required|unique:employees',
    'employee_code'=> 'required|unique:employees',
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'name'         => 'required',
      'employee_code'=> 'required|unique:employees'. ($id ? ",employee_code,$id" : ''),
    ],
    $merge);
  }
  public function getNameAttribute($value) {
    return ucfirst($this->employee_code).' '.ucfirst($value);
  }
  public function getEmployeeCodeAttribute($value) {
    return ucfirst($value);
  }
  public function Documents() {
    return $this->hasMany(Document::class,'employee_id');
  }
  public function selfCreate($data) {
    try {
      $Self=Self::onlyTrashed()->whereemployee_code($data['employee_code'])->first();
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
      if(!empty($Self->Documents->toArray())) throw new \Exception("Used in Document", 1);
      if(!$Self->delete()) throw new \Exception("Cant Delete This Employee". $id, 1);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
}
