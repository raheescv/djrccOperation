<?php
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    $this->call(User::class);
    $this->call(Profile::class);
    $this->call(ProjectModule::class);
    $this->call(UserType::class);
    $this->call(UserTypePrivilege::class);
    $this->call(Setting::class);
    $this->call(DocumentType::class);
    $this->call(Employee::class);
    $this->call(Countries::class);
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
  }
}
