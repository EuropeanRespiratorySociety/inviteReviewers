<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllErsContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_ers_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ers_id');
            $table->string('title');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('city');
            $table->string('country');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('all_ers_contacts');
    }
}
