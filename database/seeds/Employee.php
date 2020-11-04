<?php
use Illuminate\Database\Seeder;
class Employee extends Seeder
{
  public function run()
  {
    DB::table('employees')->truncate();
    $data=[];
    $data[]=['employee_code'=>'Code_1','name' => 'Rahees'];
    $data[]=['employee_code'=>'Code_2','name' => 'Sajad'];
    $data[]=['employee_code'=>'Code_3','name' => 'Rashid'];
    DB::table('employees')->insert($data);
  }
}
