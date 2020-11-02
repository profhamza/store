<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string("name", 100);
            $table->string("email", 50);
            $table->string("phone", 20);
            $table->string("address", 100);
            $table->string("logo", 200);
            $table->enum("active", [0, 1]);
            $table->bigInteger("cat_id")->unsigned();
            $table->foreign("cat_id")->references("id")->on("main_categories")->onUpdate("cascade")->onDelete("cascade");
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
        Schema::dropIfExists('vendors');
    }
}
