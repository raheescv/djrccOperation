<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;
class Reminder extends Model implements AuditableContracts {
  use Auditable;
	protected $fillable = [
		'subject',
		'date',
	];
	public $rules = [
		'subject' => 'required',
		'date'    => 'required',
	];
	public $timestamps = false;
	public function getDateAttribute($value)
	{
		return date('d-m-Y',strtotime($value));
	}
	public function Day($value){
		return \Carbon\Carbon::now()->diffInDays($value, false);
	}
}
