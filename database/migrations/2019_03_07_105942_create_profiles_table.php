<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company');
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->string('header')->nullable();
            $table->string('footer')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}