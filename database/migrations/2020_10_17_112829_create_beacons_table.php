<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateBeaconsTable extends Migration
{
  public function up()
  {
    Schema::create('beacons', function (Blueprint $table) {
      $table->id();
      //Account Information
      $table->string('hex_no')->unique();
      $table->string('beacon_type_id')->default('ELT');
      $table->unsignedBigInteger('country_id')->nullable();
      $table->string('password')->nullable();
      $table->string('security_question')->nullable();
      $table->string('security_answer')->nullable();
      $table->string('special_status')->nullable();
      $table->longText('description')->nullable();
      //Owner/Operation  Information
      $table->string('name')->nullable();
      $table->longText('address')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('postal_code')->nullable();
      $table->string('email')->nullable();
      $table->string('telephone')->nullable();
      $table->string('mobile')->nullable();

      //General Information
      $table->string('vehicle_type_id')->nullable();
      $table->string('radio_equipment')->nullable();
      $table->string('color')->nullable();

      //AirCraft Information
      $table->string('air_craft_manufacturer')->nullable();
      $table->string('air_craft_operation_agency')->nullable();

      //Vehicle Information
      $table->string('specific_usage')->nullable();
      $table->longText('additional_usage')->nullable();

      //Vessel Information
      $table->string('vessel_name')->nullable();
      $table->string('no_of_life_boats')->nullable();
      $table->string('no_of_life_rafts')->nullable();
      $table->string('radio_call_sign')->nullable();
      $table->string('radio_call_sign_decode')->nullable();
      $table->string('inmarsat')->nullable();
      $table->string('vessel_cellular')->nullable();

      //Information
      $table->string('manufacturer')->nullable();
      $table->string('model_no')->nullable();
      $table->string('c_s_type_approval_no')->nullable();
      $table->string('activation_method')->nullable();
      $table->string('beacon_home_device')->nullable();
      $table->string('additional_information')->nullable();
      // 24 Hour Emergency Contact Information
      $table->string('primary_name')->nullable();
      $table->string('primary_address_line_1')->nullable();
      $table->string('primary_address_line_2')->nullable();
      $table->string('primary_phone_number_1')->nullable();
      $table->string('primary_phone_number_2')->nullable();
      $table->string('primary_phone_number_3')->nullable();
      $table->string('primary_phone_number_4')->nullable();
      $table->string('alternative_name')->nullable();
      $table->string('alternative_address_line_1')->nullable();
      $table->string('alternative_address_line_2')->nullable();
      $table->string('alternative_phone_number_1')->nullable();
      $table->string('alternative_phone_number_2')->nullable();
      $table->string('alternative_phone_number_3')->nullable();
      $table->string('alternative_phone_number_4')->nullable();
      $table->tinyInteger('status')->default(1)->comment('1=>New,2=>Test');
      $table->unsignedBigInteger('created_by');
      $table->unsignedBigInteger('updated_by');
      $table->softDeletes();
      $table->timestamps();
      $table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict')->onUpdate('cascade');
      $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
      $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
    });
  }
  public function down()
  {
    Schema::dropIfExists('beacons');
  }
}
