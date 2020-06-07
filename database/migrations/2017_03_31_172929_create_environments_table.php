<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id')->index();
            $table->unsignedInteger('creator_id');
            $table->string('name');
            $table->text('encryption_key');
            $table->text('variables');
            $table->timestamps();
        });
    }
}
