<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rent')->default(100);
            $table->integer('days')->default(1);
        });

        DB::table('setting_product')->insert([
            'rent' => 100,
            'days' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_product');
    }
}
