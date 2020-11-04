<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUsersTable extends Migration
{
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id('id');
      $table->string('name');
      $table->string('image')->nullable();
      $table->string('first_name')->nullable();
      $table->string('country_code')->nullable();
      $table->string('mobile')->nullable();
      $table->string('last_name')->nullable();
      $table->string('nick_name');
      $table->string('web_site')->nullable();
      $table->integer('user_type_id');
      $table->string('email')->unique();
      $table->string('password');
      $table->integer('status')->default(0);
      $table->integer('flag')->default(0);
      $table->rememberToken();
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
