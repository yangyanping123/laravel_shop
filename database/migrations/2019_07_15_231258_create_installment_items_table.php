<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installment_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('installment_id');
            $table->foreign('installment_id')->references('id')->on('installments')->onDelete('cascade');
            $table->unsignedInteger('sequence');
            $table->decimal('base');
            $table->decimal('fee');
            $table->decimal('fine')->nullable();
            $table->dateTime('due_date');
            $table->dateTime('paid_at')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_no')->nullable();
            $table->string('refund_status');
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
        Schema::dropIfExists('installment_items');
    }
}