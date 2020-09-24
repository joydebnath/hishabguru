<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('product_category_id');
            $table->string('buying_unit_cost')->nullable();
            $table->string('selling_unit_price')->nullable();
            $table->integer('quantity')->nullable()->comment('Total quantity across all the sites');
            $table->decimal('tax_rate')->default(0);
            $table->text('description')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
