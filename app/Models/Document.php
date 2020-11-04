<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;
use Carbon\Carbon;
class Document extends Model implements AuditableContracts {
  use Auditable;
  protected $fillable = [
    'employee_id',
    'document_type_id',
    'date_of_issue',
    'date_of_expiry',
  ];
  public $rules = [
    'employee_id'      => 'required',
    'document_type_id' => 'required',
    'date_of_issue'    => 'required',
    'date_of_expiry'   => 'required',
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'employee_id'         => 'required',
      'document_type_id'    => 'required',
      'date_of_issue'       => 'required',
      'date_of_expiry'      => 'required',
    ],
    $merge);
  }
  public function Employee(){
    return $this->belongsTo(Employee::class);
  }
  public function DocumentType(){
    return $this->belongsTo(DocumentType::class);
  }
  public function Duration() {
    $date_of_expiry = strtotime($this->date_of_expiry);
    $date_of_issue = strtotime($this->date_of_issue);
    $datediff = $date_of_expiry - $date_of_issue;
    return round($datediff / (60 * 60 * 24)).' Days';
  }
  public function Remaining() {
    $days=\Carbon\Carbon::now()->diffInDays($this->date_of_expiry, false);
    if($days==0){
      $days='Expire Today';
    } elseif($days<0){
      $days='Expired';
    } else {
      $days=$days.' Days';
    }
    return $days;
  }

  public function selfCreate($data) {
    try {
      $Self=Self::whereemployee_id($data['employee_id'])->wheredocument_type_id($data['document_type_id'])->first();
      if($Self) throw new \Exception("Already Added", 1);
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
      $Self=Self::find($id);
      if(!isset($data['employee_id'])) $data['employee_id']=$Self->employee_id;
      if(!isset($data['document_type_id'])) $data['document_type_id']=$Self->document_type_id;
      $validator = \Validator::make($data,$this->rules($id));
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new \Exception($value[0]); } }
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
      if(!$Self->delete()) throw new \Exception("Cant Delete This Employee". $id, 1);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }

}
