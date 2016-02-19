<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method');
            $table->string('name');
            $table->string('uses');
            $table->string('uri_prefix');
            $table->string('uri_suffix');
            $table->string('custom_uri');
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('in_menu');
            $table->softDeletes();
        });

        Schema::table('pages',
            function (Blueprint $table) {$table->foreign('parent_id')->references('id')->on('pages');});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages',
            function (Blueprint $table){$table->dropForeign('pages_parent_id_foreign');});

        Schema::drop('pages');;
    }
}
