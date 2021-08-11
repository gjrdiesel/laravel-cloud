<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaemonGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daemon_generations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('generationable_id');
            $table->string('generationable_type');
            $table->timestamps();

            $table->index(['generationable_id', 'generationable_type'], 'generationable_morphs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daemon_generations');
    }
}
