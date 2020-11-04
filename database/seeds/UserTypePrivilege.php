<?php
use Illuminate\Database\Seeder;
class UserTypePrivilege extends Seeder
{
	public function run()
	{
		DB::table('user_type_privileges')->truncate();
		$data=[];
		$user_types=DB::table('user_types')->get();
		$project_modules=DB::table('project_modules')->get();
		for ($j=0; $j <count($user_types) ; $j++) { 
			for ($i=0; $i <count($project_modules) ; $i++) { 
				$data[]=[
					'user_type_id'     =>$user_types[$j]->id,
					'project_module_id'=>$project_modules[$i]->id
				];
			}
		}
		DB::table('user_type_privileges')->insert($data);
	}
}
