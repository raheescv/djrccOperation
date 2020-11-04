<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUserTypesTable extends Migration
{
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('freeze')->default(0);
        });
    }
    public function down()
    {
        Schema::dropIfExists('user_types');
    }
}
