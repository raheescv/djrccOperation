<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;
class UserTypePrivilege extends Model implements AuditableContracts {
  use Auditable;
  protected $fillable = [
    'user_type_id',
    'project_module_id',
  ];
  public $timestamps = false;
  public $rules = [
    'user_type_id'      => 'required',
    'project_module_id' => 'required',
  ];
}
