<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateSchedulesTable extends Migration
{
  public function up()
  {
    Schema::create('schedules', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('employee_id');
      $table->date('date')->default(date("Y-m-d"));
      $table->time('time');
      $table->longText('remarks')->nullable();
      $table->foreign('employee_id')->references('id')->on('employees')->onDelete('restrict')->onUpdate('cascade');
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists('schedules');
  }
}
