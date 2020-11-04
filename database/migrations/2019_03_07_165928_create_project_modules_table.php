<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProjectModulesTable extends Migration
{
    public function up()
    {
        Schema::create('project_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('module');
            $table->string('sub_module');
        });
    }
    public function down()
    {
        Schema::dropIfExists('project_modules');
    }
}
