<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateSituationDetailsTable extends Migration
{
  public function up()
  {
    Schema::create('situation_details', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('situation_id');
      $table->date('date')->default(date("Y-m-d"));
      $table->time('time');
      $table->longText('details');
      $table->longText('initial')->nullable();
      $table->timestamps();
      $table->foreign('situation_id')->references('id')->on('situations')->onDelete('restrict')->onUpdate('cascade');
    });
  }
  public function down()
  {
    Schema::dropIfExists('situation_details');
  }
}
