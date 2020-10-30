<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopyReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copy_references', function (Blueprint $table) {
            $table->id();
            $table->string('copy_from_type');
            $table->unsignedBigInteger('copy_from_id');
            $table->string('copy_to_type');
            $table->unsignedBigInteger('copy_to_id');
            $table->timestamps();

            $table->index(['copy_from_id','copy_from_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('copy_references');
    }
}
