<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReviewPulseTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Store $store;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Alex Morgan',
            'email' => 'demo@reviewpulse.test',
            'password' => Hash::make('password'),
        ]);

        $this->store = Store::create([
            'user_id' => $this->user->id,
            'name' => 'Caint Electronics',
            'platform_store_id' => 'caint-electronics-us',
            'timezone' => 'America/New_York',
            'webhook_secret' => 'rp_sec_test_secret_123',
        ]);
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('ReviewPulse');
        $response->assertSee('Sign in to ReviewPulse');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'demo@reviewpulse.test',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_dashboard_displays_real_metrics_and_reviews(): void
    {
        Review::create([
            'store_id' => $this->store->id,
            'reviewer_name' => 'Jane W.',
            'product_name' => 'Wireless Headphones',
            'rating' => 1,
            'review_text' => 'Left earbud broke after two days.',
            'review_status' => 'needs_review',
            'processing_status' => 'completed',
            'sentiment' => 'negative',
            'confidence_score' => 0.95,
            'requires_human_review' => true,
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Caint Electronics');
        $response->assertSee('Jane W.');
        $response->assertSee('Negative / Risk');
    }

    public function test_five_star_review_intake_produces_positive_classification_and_draft(): void
    {
        $response = $this->postJson('/api/reviews', [
            'store_id' => $this->store->id,
            'reviewer_name' => 'Michael Chen',
            'product_name' => 'USB-C Dock',
            'rating' => 5,
            'review_text' => 'Outstanding performance and fast charging. Absolutely love it!',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'processing_status' => 'completed',
            'sentiment' => 'positive',
        ]);

        $this->assertDatabaseHas('reviews', [
            'reviewer_name' => 'Michael Chen',
            'rating' => 5,
            'sentiment' => 'positive',
        ]);
    }

    public function test_one_star_complaint_produces_negative_classification_and_human_review_flag(): void
    {
        $response = $this->postJson('/api/reviews', [
            'store_id' => $this->store->id,
            'reviewer_name' => 'Jane W.',
            'product_name' => 'Wireless Headphones',
            'rating' => 1,
            'review_text' => 'My headphones arrived late, and the left earbud stopped working after two days. I am disappointed with the quality.',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'processing_status' => 'completed',
            'sentiment' => 'negative',
            'review_status' => 'needs_review',
        ]);

        $this->assertDatabaseHas('reviews', [
            'reviewer_name' => 'Jane W.',
            'rating' => 1,
            'sentiment' => 'negative',
            'requires_human_review' => true,
            'review_status' => 'needs_review',
        ]);
    }

    public function test_empty_review_text_and_invalid_rating_rejected_with_validation_error(): void
    {
        $response = $this->postJson('/api/reviews', [
            'store_id' => $this->store->id,
            'reviewer_name' => 'Test User',
            'product_name' => 'Widget',
            'rating' => 8, // Invalid rating > 5
            'review_text' => '', // Empty review text
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['rating', 'review_text']);
    }

    public function test_edit_reply_and_save_draft_creates_history_record(): void
    {
        $review = Review::create([
            'store_id' => $this->store->id,
            'reviewer_name' => 'Sarah J.',
            'product_name' => 'Earbuds',
            'rating' => 5,
            'review_text' => 'Great sound quality!',
            'review_status' => 'pending',
            'processing_status' => 'completed',
            'ai_generated_reply' => 'Original AI Draft response.',
            'suggested_reply' => 'Original AI Draft response.',
        ]);

        $response = $this->actingAs($this->user)->post("/reviews/{$review->id}/reply", [
            'suggested_reply' => 'Edited customized response from store owner.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'suggested_reply' => 'Edited customized response from store owner.',
        ]);

        $this->assertDatabaseHas('review_reply_history', [
            'review_id' => $review->id,
            'edited_reply' => 'Edited customized response from store owner.',
            'action_type' => 'edit',
        ]);
    }

    public function test_approve_reply_updates_review_status(): void
    {
        $review = Review::create([
            'store_id' => $this->store->id,
            'reviewer_name' => 'Amanda B.',
            'product_name' => 'Ergonomic Mouse',
            'rating' => 4,
            'review_text' => 'Very comfortable to use.',
            'review_status' => 'pending',
            'processing_status' => 'completed',
            'suggested_reply' => 'Thank you for your feedback!',
        ]);

        $response = $this->actingAs($this->user)->post("/reviews/{$review->id}/approve");

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'review_status' => 'approved',
        ]);
    }

    public function test_send_demo_mode_updates_status_to_sent(): void
    {
        $review = Review::create([
            'store_id' => $this->store->id,
            'reviewer_name' => 'Robert T.',
            'product_name' => 'Wireless Charger',
            'rating' => 5,
            'review_text' => 'Awesome charger!',
            'review_status' => 'approved',
            'processing_status' => 'completed',
            'suggested_reply' => 'Glad you love the wireless charger, Robert!',
        ]);

        $response = $this->actingAs($this->user)->post("/reviews/{$review->id}/send-demo");

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'review_status' => 'sent',
        ]);
    }

    public function test_secure_internal_analysis_callback_validates_secret_and_saves_data(): void
    {
        $review = Review::create([
            'store_id' => $this->store->id,
            'reviewer_name' => 'David M.',
            'product_name' => 'Mechanical Keyboard',
            'rating' => 3,
            'review_text' => 'Bluetooth disconnects sometimes.',
            'review_status' => 'pending',
            'processing_status' => 'queued',
        ]);

        $response = $this->withHeader('X-ReviewPulse-Secret', 'rp_sec_test_secret_123')
            ->postJson("/api/internal/reviews/{$review->id}/analysis", [
                'sentiment' => 'neutral',
                'confidence' => 0.88,
                'summary' => 'Customer noted occasional Bluetooth disconnections.',
                'suggested_reply' => 'Thanks for the review David, firmware update is coming soon.',
                'requires_human_review' => false,
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'sentiment' => 'neutral',
            'ai_summary' => 'Customer noted occasional Bluetooth disconnections.',
            'processing_status' => 'completed',
        ]);

        $this->assertDatabaseHas('automation_logs', [
            'review_id' => $review->id,
            'workflow_type' => 'n8n_callback',
            'status' => 'completed',
        ]);
    }

    public function test_wrong_internal_secret_is_unauthorized(): void
    {
        $review = Review::create([
            'store_id' => $this->store->id,
            'reviewer_name' => 'David M.',
            'rating' => 3,
            'review_text' => 'Testing unauthorized callback.',
            'review_status' => 'pending',
            'processing_status' => 'queued',
        ]);

        $response = $this->withHeader('X-ReviewPulse-Secret', 'wrong_secret')
            ->postJson("/api/internal/reviews/{$review->id}/analysis", [
                'sentiment' => 'neutral',
                'confidence' => 0.88,
                'summary' => 'Testing unauthorized callback.',
                'suggested_reply' => 'Testing unauthorized callback.',
            ]);

        $response->assertStatus(401);
    }
}
