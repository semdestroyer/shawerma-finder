<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShawermasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shawermas', function (Blueprint $table) {
            $table->id();
            $table->string("author_telegram_id");
            $table->string("name");
            $table->text("description");
            $table->float("longtitude");
            $table->float("latitude");
            $table->integer("rating");
            $table->text("cover_photo");
            $table->softDeletes();
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
        Schema::dropIfExists('shawermas');
    }
}
