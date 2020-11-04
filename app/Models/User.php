<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;
class User extends Authenticatable implements AuditableContracts {
  use Auditable,Notifiable;
	protected $guarded = [];
	protected $hidden = [
		'password', 'remember_token',
	];
	public $rules = [
		'name'         => 'required|unique:users',
  	'nick_name'    => 'required',
		'user_type_id' => 'required',
		'email'        => 'required|unique:users',
		'password'     => 'required|min:6|same:password',
	];
	public function getNameAttribute($value)
	{
		return ucfirst($value);
	}
	public function UserType(){
		return $this->belongsTo(UserType::class);
	}
	public function UserTypePrivilege($project_sub_module,$user_type_id){
		$availability=0;
		$UserTypePrivilege=UserTypePrivilege::leftJoin('project_modules', 'user_type_privileges.project_module_id', '=', 'project_modules.id');
		$UserTypePrivilege=$UserTypePrivilege->where('project_modules.sub_module',$project_sub_module)->whereuser_type_id($user_type_id)->first();
		if($UserTypePrivilege) $availability=1;
		return $availability;
	}
	public function UserTypePrivilegeModule($project_module,$user_type_id){
		$availability=0;
		$UserTypePrivilege=UserTypePrivilege::leftJoin('project_modules', 'user_type_privileges.project_module_id', '=', 'project_modules.id');
		$UserTypePrivilege=$UserTypePrivilege->where('project_modules.module',$project_module)->whereuser_type_id($user_type_id)->first();
		if($UserTypePrivilege) $availability=1;
		return $availability;
	}
}
