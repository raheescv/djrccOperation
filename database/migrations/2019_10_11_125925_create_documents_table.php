<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id');
            $table->integer('document_type_id');
            $table->date('date_of_issue');
            $table->date('date_of_expiry');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
