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
        Schema::create('borrow', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // $table->string('publisher');
            // $table->string('isbn');
            // $table->string('category');
            // $table->string('sub_category');
            // $table->string('description');
            $table->string('added_by');
            $table->integer('pages');
            // $table->string('image')->default(0);
            $table->string('book_id')->default(0);
            $table->string('extended')->default(0);
            $table->string('extension_date')->default(0);
            $table->integer('penalty_amount')->default(0); // Corrected default value syntax
            $table->string('penalty_status')->default(false); // Corrected default value syntax
            $table->boolean('status')->default(false);
            $table->string('user_id')->default(0);
            $table->string('loan_date')->default(0);
            $table->string('return_date')->default(0);
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
        Schema::dropIfExists('test');
    }
};
