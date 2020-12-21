<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateLogsTable extends Migration
{
  public function up()
  {
    Schema::create('logs', function (Blueprint $table) {
      $table->id();
      $table->date('date')->default(date("Y-m-d"));
      $table->unsignedBigInteger('cordinator_id');
      $table->longText('remarks')->nullable();
      $table->time('entry_time');
      $table->time('exit_time');
      $table->timestamps();
      $table->foreign('cordinator_id')->references('id')->on('employees')->onDelete('restrict')->onUpdate('cascade');
    });
  }
  public function down()
  {
    Schema::dropIfExists('logs');
  }
}
