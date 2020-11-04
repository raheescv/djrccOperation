<?php
use Illuminate\Database\Seeder;
class UserType extends Seeder
{
  public function run()
  {
    DB::table('user_types')->truncate();
    $data=[];
    $data[]=['name' => 'Super Admin'      ,'freeze'=>1];
    $data[]=['name' => 'Admin'            ,'freeze'=>1];
    $data[]=['name' => 'Manager'          ,'freeze'=>0];
    $data[]=['name' => 'Receptionist'     ,'freeze'=>0];
    $data[]=['name' => 'Service Engineer' ,'freeze'=>0];
    $data[]=['name' => 'Sales Excecutive' ,'freeze'=>0];
    DB::table('user_types')->insert($data);
  }
}
