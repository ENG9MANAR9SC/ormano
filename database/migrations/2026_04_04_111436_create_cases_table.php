<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            $table->string('status');
            $table->string('priority')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('court_id')->nullable()->constrained('courts')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
