<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('addressable_id');
            $table->string('addressable_type');
            $table->string('public_address');
            $table->string('private_address');
            $table->timestamps();

            $table->index(['addressable_id', 'addressable_type']);
            $table->index('public_address');
        });
    }
}
