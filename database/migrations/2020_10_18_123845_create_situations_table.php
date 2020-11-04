<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateSituationsTable extends Migration
{
  public function up()
  {
    Schema::create('situations', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('beacon_id');
      $table->unsignedBigInteger('country_id');
      $table->string('registered')->default('Yes');
      $table->unsignedBigInteger('opened_by');
      $table->unsignedBigInteger('closed_by');
      $table->timestamps();
      $table->foreign('beacon_id')->references('id')->on('beacons')->onDelete('restrict')->onUpdate('cascade');
      $table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict')->onUpdate('cascade');
      $table->foreign('opened_by')->references('id')->on('employees')->onDelete('restrict')->onUpdate('cascade');
      $table->foreign('closed_by')->references('id')->on('employees')->onDelete('restrict')->onUpdate('cascade');
    });
  }
  public function down()
  {
    Schema::dropIfExists('situations');
  }
}
