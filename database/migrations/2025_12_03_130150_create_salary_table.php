<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            // Foreign key to users table
            $table->unsignedBigInteger('user_id');
            $table->decimal('salary', 10, 2);
            $table->decimal('savings', 10, 2);
            $table->decimal('rent_or_emi', 10, 2);

            $table->decimal('food_and_groceries', 10, 2);
            $table->decimal('transportation', 10, 2);
            $table->decimal('utilities', 10, 2);
            $table->decimal('internet_and_mobile', 10, 2);
            $table->decimal('insurance', 10, 2);
            $table->decimal('entertainment', 10, 2);
            $table->decimal('personal_care', 10, 2);
            $table->decimal('miscellaneous', 10, 2);
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
        Schema::dropIfExists('salaries');
    }
}
