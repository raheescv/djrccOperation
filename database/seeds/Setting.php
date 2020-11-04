<?php
use Illuminate\Database\Seeder;
class Setting extends Seeder
{
  public function run()
  {
    DB::table('settings')->truncate();
    $data=[
      'collapse_menu'  =>'No',
      'fixed_nav_bar'  =>'Yes',
      'fixed_side_bar' =>'Yes',
      'fixed_footer'   =>'No',
      'skin'           =>'md-skin',
      'created_at'     =>date('Y-m-d H:i:s'),
      'updated_at'     =>date('Y-m-d H:i:s'),
    ];
    DB::table('settings')->insert($data);
  }
}
