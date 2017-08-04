<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain')->nullable();
            $table->string('subdomain')->nullable();
            $table->string('header');
            $table->string('sign_up_text');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');
        });
    }

    /**r
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_pages');
    }
}
