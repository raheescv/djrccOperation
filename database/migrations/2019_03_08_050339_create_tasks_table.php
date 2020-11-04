<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('color')->default('#0088cc');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('status')->default('1');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
