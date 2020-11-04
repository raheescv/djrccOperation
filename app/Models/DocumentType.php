<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
class DocumentType extends Model implements AuditableContracts {
  use Auditable;
  use SoftDeletes;
  protected $fillable = [
    'name',
  ];
  public $rules = [
    'name' => 'required|unique:document_types',
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'name'=> 'required|unique:document_types'. ($id ? ",name,$id" : ''),
    ],
    $merge);
  }
  public function getNameAttribute($value) {
    return ucfirst($value);
  }
  public function Documents() {
    return $this->hasMany(Document::class,'document_type_id');
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
      if(!empty($Self->Documents->toArray())) throw new \Exception("Used in Document", 1);
      if(!$Self->delete()) throw new \Exception("Cant Delete This DocumentType". $id, 1);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
}
