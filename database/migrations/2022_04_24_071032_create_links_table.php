<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('short_code', config('services.code.length'))->unique();
            $table->string('original_url', 400);
            $table->integer('clicks_limit')->default(0);
            $table->integer('clicks')->default(0);
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();

            $table->index('short_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
};
