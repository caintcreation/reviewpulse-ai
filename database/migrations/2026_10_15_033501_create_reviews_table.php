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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->string('reviewer_name');
            $table->string('product_name')->nullable();
            $table->integer('rating');
            $table->text('review_text');
            $table->string('review_status')->default('unread'); // unread, pending, needs_review, approved, sent, archived
            $table->string('processing_status')->default('pending'); // pending, queued, processing, completed, failed
            $table->text('ai_generated_reply')->nullable();
            $table->text('suggested_reply')->nullable();
            $table->string('sentiment')->nullable(); // positive, neutral, negative
            $table->decimal('confidence_score', 4, 3)->nullable(); // e.g., 0.950
            $table->text('ai_summary')->nullable();
            $table->boolean('requires_human_review')->default(false);
            $table->string('source')->default('demo'); // demo, google, shopify, etc.
            $table->string('external_review_id')->nullable();
            $table->timestamps();

            $table->index(['store_id', 'review_status']);
            $table->index(['store_id', 'sentiment']);
            $table->index(['store_id', 'processing_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
