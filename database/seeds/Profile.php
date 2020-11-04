<?php
use Illuminate\Database\Seeder;
class Profile extends Seeder
{
    public function run()
    {
		DB::table('profiles')->truncate();
		$data=[
			'company' => 'Company Name' ,
			'image' => '' ,
			'logo' => '' ,
			'header' => 'header Name' ,
			'footer' => 'footer Name' ,
			'address_line_1' => 'address_line_1' ,
			'address_line_2' => 'address_line_2' ,
			'address_line_3' => 'address_line_3' ,
			'mobile' => '+97470598308' ,
			'email' => 'shamlan@technoastra.com' ,
		];
		DB::table('profiles')->insert($data);
    }
}
