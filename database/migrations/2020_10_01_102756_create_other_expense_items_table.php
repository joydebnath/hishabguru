<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherExpenseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_expense_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('other_expense_id')->index();
            $table->integer('quantity')->default(1);
            $table->unsignedDecimal('buying_unit_cost');
            $table->unsignedDecimal('tax_rate')->default(0)->nullable();
            $table->unsignedDecimal('total');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('other_expense_id')->references('id')->on('other_expenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_expense_items');
    }
}
