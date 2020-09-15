<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('type');
            $table->decimal('discount');
            $table->integer('usage_limit')->nullable();
            $table->integer('minimum_spend')->nullable();
            $table->integer('maximum_spend')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('tenant_id');
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_codes');
    }
}
