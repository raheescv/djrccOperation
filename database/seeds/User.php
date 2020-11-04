<?php
use Illuminate\Database\Seeder;
class User extends Seeder
{
  public function run()
  {
    DB::table('users')->truncate();
    $data=[];
    $data[]=[
      'name'         => 'Admin' ,
      'nick_name'    => 'Admin' ,
      'user_type_id' => '1' ,
      'email'        =>'admin@gmail.com',
      'password'     =>'asdasd',
      'created_at'   =>date('Y-m-d H:i:s'),
      'updated_at'   =>date('Y-m-d H:i:s'),
    ];
    $data[]=[
      'name'         => 'Rahees' ,
      'nick_name'    => 'Admin' ,
      'user_type_id' => '1' ,
      'email'        =>'raheescv1992@gmail.com',
      'password'     =>'asdasd',
      'created_at'   =>date('Y-m-d H:i:s'),
      'updated_at'   =>date('Y-m-d H:i:s'),
    ];
    DB::table('users')->insert($data);
  }
}
