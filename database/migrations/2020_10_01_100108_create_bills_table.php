<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number');
            $table->string('reference_number')->nullable();
            $table->string('status');
            $table->dateTime('issue_date');
            $table->dateTime('due_date')->nullable();

            $table->unsignedDecimal('total_amount')->nullable();
            $table->unsignedDecimal('total_paid')->nullable();
            $table->unsignedDecimal('total_due')->nullable();
            $table->unsignedDecimal('sub_total')->nullable();
            $table->unsignedDecimal('total_tax')->nullable();
            $table->text('note')->nullable();

            $table->unsignedBigInteger('tenant_id')->index();
            $table->unsignedBigInteger('contact_id')->index()->nullable()->comment('purchased from a contact');
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('approved_by')->index()->nullable();

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
