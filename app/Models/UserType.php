<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;
class UserType extends Model implements AuditableContracts {
  use Auditable;
  protected $fillable = [
    'name',
  ];
  public $timestamps = false;
  public $rules = [
    'name' => 'required|unique:user_types',
  ];
}
