<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ers_id')->unique()->unsigned();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('ers_id')
                  ->references('ers_id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invitation_permissions');
    }
}
