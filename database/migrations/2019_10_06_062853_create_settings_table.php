<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('collapse_menu')->default('No');
            $table->string('fixed_nav_bar')->default('Yes');
            $table->string('fixed_side_bar')->default('Yes');
            $table->string('fixed_footer')->default('No');
            $table->string('skin')->default('skin-0');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
