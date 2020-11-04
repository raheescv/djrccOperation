<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateRemindersTable extends Migration
{
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->date('date')->default(date('Y-m-d'));
        });
    }
    public function down()
    {
        Schema::dropIfExists('reminders');
    }
}
