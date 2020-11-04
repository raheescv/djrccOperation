<?php
use Illuminate\Database\Seeder;
class DocumentType extends Seeder
{
  public function run()
  {
    DB::table('document_types')->truncate();
    $data=[];
    $data[]=['name' => 'Driving Lisence'];
    $data[]=['name' => 'Health Card'];
    $data[]=['name' => 'Gate Pass'];
    DB::table('document_types')->insert($data);
  }
}
