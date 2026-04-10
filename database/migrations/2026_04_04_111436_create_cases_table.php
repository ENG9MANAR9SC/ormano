<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();

            $table->string('case_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type');

            $table->string('status');
            $table->string('priority')->nullable()->index();

            $table->date('filing_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('next_hearing_date')->nullable();

            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('court_id')->nullable()->constrained('courts')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['client_id', 'status', 'type']);
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
