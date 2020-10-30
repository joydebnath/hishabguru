<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_contact_id')->index();
            $table->unsignedBigInteger('child_contact_id')->index();
            $table->timestamps();

            $table->foreign('parent_contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('child_contact_id')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_contacts');
    }
}
