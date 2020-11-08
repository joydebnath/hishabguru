<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactCreditRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_credit_records', function (Blueprint $table) {
            $table->id();
            $table->decimal('open_balance');
            $table->enum('type', ['creditor', 'debtor']);
            $table->timestamps();

            $table->foreignId('contact_id')->index()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_credit_records');
    }
}
