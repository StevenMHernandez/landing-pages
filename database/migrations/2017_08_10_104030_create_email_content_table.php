<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('landing_page_id');
            $table->text('thanks_text');
            $table->text('description_text');
            $table->timestamps();
            $table->foreign('landing_page_id')
                ->references('id')
                ->on('landing_pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('email_contents');
    }
}
