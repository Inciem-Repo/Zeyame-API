<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->unsignedSmallInteger('year')->after('salary');
            $table->unsignedTinyInteger('month')->after('year');
            $table->integer('savings')->nullable()->change();
            $table->integer('rent_or_emi')->nullable()->change();
            $table->integer('food_and_groceries')->nullable()->change();
            $table->integer('transportation')->nullable()->change();
            $table->integer('utilities')->nullable()->change();
            $table->integer('internet_and_mobile')->nullable()->change();
            $table->integer('insurance')->nullable()->change();
            $table->integer('entertainment')->nullable()->change();
            $table->integer('personal_care')->nullable()->change();
            $table->integer('miscellaneous')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salaries', function (Blueprint $table) {
            // Then drop the columns
            $table->dropColumn(['year', 'month']);
        });
    }
}
