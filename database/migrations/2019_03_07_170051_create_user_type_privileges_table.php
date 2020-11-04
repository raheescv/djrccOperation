<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUserTypePrivilegesTable extends Migration
{
    public function up()
    {
        Schema::create('user_type_privileges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_type_id');
            $table->integer('project_module_id');
        });
    }
    public function down()
    {
        Schema::dropIfExists('user_type_privileges');
    }
}
