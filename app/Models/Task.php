<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;
class Task extends Model implements AuditableContracts {
  use Auditable;
    protected $fillable = [
		'title',
		'description',
		'color',
		'date',
		'start_time',
		'end_time',
		'status',
	];
	public $rules = [
		'title'           =>'required',
		'date'            =>'required',
		'start_time'      =>'required',
		'end_time'        =>'required',
		'status'          =>'required',
	];
	public function getTitleAttribute($value)
	{
		return ucfirst($value);
	}
}
