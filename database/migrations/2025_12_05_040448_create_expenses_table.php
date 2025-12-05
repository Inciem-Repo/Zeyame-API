<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('expense_category_id')->index();
            $table->decimal('amount', 10, 2);
            $table->date('spent_at')->index();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id', 'spent_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
