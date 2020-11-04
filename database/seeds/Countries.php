<?php
use Illuminate\Database\Seeder;
class Countries extends Seeder
{
  public function run()
  {
    DB::table('countries')->truncate();
    $data=[];
    $data[]=['name' => 'Qatar','code'=>"QA"];
    $data[]=['name' => 'US','code'=>"US"];
    $data[]=['name' => 'India','code'=>"IN"];
    DB::table('countries')->insert($data);
  }
}
