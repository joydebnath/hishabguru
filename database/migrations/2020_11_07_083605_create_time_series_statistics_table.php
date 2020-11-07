<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSeriesStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_series_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('statistic_type');
            $table->date('date');
            $table->string('value');
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->index(['tenant_id', 'statistic_type']);
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
        Schema::dropIfExists('time_series_statistics');
    }
}
