<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateActivityLogTable extends Migration
{
    public function up()
    {
        Schema::connection(config('activitylog.database_connection'))->create(config('activitylog.table_name'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject')->nullable();
            $table->text('method');
            $table->text('url');
            $table->unsignedBigInteger('user_id');
            $table->text('ip');
            $table->text('agent');
            $table->timestamps();
            $table->index('user_id');
        });
    }
    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->dropIfExists(config('activitylog.table_name'));
    }
}
