<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('start')->nullable()->default(null);
            $table->timestamp('end')->nullable()->default(null);

            $table->string('requested')->nullable();

            $table->float('discount')->nullable();
            $table->string('reason')->nullable();

            $table->uuid('approver_id')->nullable();
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');

            $table->string('status')->default('pending');
            
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
        Schema::dropIfExists('bookings');
    }
}
