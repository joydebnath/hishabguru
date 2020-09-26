<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_number');
            $table->string('reference_number')->nullable();
            $table->string('status');
            $table->dateTime('create_date');
            $table->dateTime('delivery_date')->nullable();

            $table->unsignedDecimal('total_amount')->nullable();
            $table->unsignedDecimal('sub_total')->nullable();
            $table->unsignedDecimal('total_tax')->nullable();
            $table->text('note')->nullable();

            $table->unsignedBigInteger('delivery_site_id')->nullable();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('contact_id')->nullable()->comment('purchased from a contact');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('approved_by')->nullable();

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
        Schema::dropIfExists('purchases');
    }
}
