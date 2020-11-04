<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;
class Profile extends Model implements AuditableContracts
{
  use Auditable;
	protected $fillable = [
		'company',
		'logo',
		'image',
		'header',
		'footer',
		'address_line_1',
		'address_line_2',
		'address_line_3',
		'mobile',
		'email',
	];
	protected $auditExclude = [
		'logo',
		'image',
	];
	public $timestamps = false;
	public function getCompanyAttribute($value)
	{
		return ucfirst($value);
	}
	public function getHeaderAttribute($value)
	{
		return ucfirst($value);
	}
	public function getFooterAttribute($value)
	{
		return ucfirst($value);
	}
}
