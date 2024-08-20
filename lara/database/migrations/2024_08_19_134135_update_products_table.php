<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  Schema::table('products', function (Blueprint $table) 
        //  {
        //     $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        //     $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        //     $table->foreign('sale_id')->references('id')->on('sales')->onDelete('set null');
        //  });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
