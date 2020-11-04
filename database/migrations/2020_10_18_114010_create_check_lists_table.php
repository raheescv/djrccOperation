<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateCheckListsTable extends Migration
{
  public function up()
  {
    Schema::create('check_lists', function (Blueprint $table) {
      $table->id();
      $table->time('time');
      $table->date('date')->default(date("Y-m-d"));
      $table->string('sarp_data')->nullable();
      $table->string('orbit_data')->nullable();
      $table->string('ftp_link')->nullable();
      $table->string('aftn_link')->nullable();
      $table->string('amhs_link')->nullable();
      $table->string('tele_fax')->nullable();
      $table->string('printer')->nullable();
      $table->string('ops_room_status')->nullable();
      $table->string('leo_lut')->nullable();
      $table->string('geo_lut')->nullable();
      $table->unsignedBigInteger('employee_id');
      $table->timestamps();
      $table->foreign('employee_id')->references('id')->on('employees')->onDelete('restrict')->onUpdate('cascade');
    });
  }
  public function down()
  {
    Schema::dropIfExists('check_lists');
  }
}
