<?php

namespace Database\Seeders;

use App\Models\AutomationLog;
use App\Models\Review;
use App\Models\ReviewReplyHistory;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with demo data.
     */
    public function run(): void
    {
        // 1. Create primary demo user
        $user = User::updateOrCreate(
            ['email' => 'demo@reviewpulse.test'],
            [
                'name' => 'Alex Morgan',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Create demo store (Caint Electronics from the specification)
        $store = Store::updateOrCreate(
            ['platform_store_id' => 'caint-electronics-us'],
            [
                'user_id' => $user->id,
                'name' => 'Caint Electronics',
                'timezone' => 'America/New_York',
                'webhook_secret' => 'rp_sec_live_9876543210abcdef',
            ]
        );

        // 3. Realistic Demo Reviews
        $demoReviews = [
            [
                'reviewer_name' => 'Jane W.',
                'product_name' => 'Wireless Headphones Pro',
                'rating' => 1,
                'review_text' => 'My headphones arrived late, and the left earbud stopped working after two days. I am disappointed with the quality.',
                'review_status' => 'needs_review',
                'processing_status' => 'completed',
                'sentiment' => 'negative',
                'confidence_score' => 0.965,
                'requires_human_review' => true,
                'ai_summary' => 'Customer reports a late delivery and a faulty left earbud shortly after receiving the headphones.',
                'suggested_reply' => "We're sorry to hear about your experience with your headphones, Jane. We understand how frustrating it is to receive a late delivery and then encounter a hardware issue. We'd like to help resolve this immediately. Please reach out to our support team at support@caintelectronics.com with your order number so we can arrange a replacement.",
                'ai_generated_reply' => "We're sorry to hear about your experience with your headphones, Jane. We understand how frustrating it is to receive a late delivery and then encounter a hardware issue. We'd like to help resolve this immediately. Please reach out to our support team at support@caintelectronics.com with your order number so we can arrange a replacement.",
                'source' => 'google',
                'external_review_id' => 'g-rev-101',
                'created_at' => now()->subHours(2),
            ],
            [
                'reviewer_name' => 'Michael Chen',
                'product_name' => 'UltraFast USB-C 10-in-1 Hub',
                'rating' => 5,
                'review_text' => 'Absolute game changer for my dual monitor setup! All ports run at full speed and it barely gets warm. Customer service was also super responsive when I had a question before ordering.',
                'review_status' => 'sent',
                'processing_status' => 'completed',
                'sentiment' => 'positive',
                'confidence_score' => 0.992,
                'requires_human_review' => false,
                'ai_summary' => 'Customer praises the hub performance with dual monitors and the fast customer support.',
                'suggested_reply' => 'Thank you so much for the fantastic feedback, Michael! We are thrilled to hear the USB-C Hub is powering your dual monitor setup flawlessly. Enjoy the productivity boost!',
                'ai_generated_reply' => 'Thank you so much for the fantastic feedback, Michael! We are thrilled to hear the USB-C Hub is powering your dual monitor setup flawlessly. Enjoy the productivity boost!',
                'source' => 'shopify',
                'external_review_id' => 'sp-rev-202',
                'created_at' => now()->subHours(5),
            ],
            [
                'reviewer_name' => 'Sarah Jenkins',
                'product_name' => 'ANC Wireless Headphones Pro',
                'rating' => 5,
                'review_text' => 'Crisp sound, deep bass, and top tier battery life. I took these on a 14-hour flight and they still had 40% battery left. Highly recommended!',
                'review_status' => 'approved',
                'processing_status' => 'completed',
                'sentiment' => 'positive',
                'confidence_score' => 0.985,
                'requires_human_review' => false,
                'ai_summary' => 'Customer highlights outstanding audio quality and impressive 14+ hour battery endurance during travel.',
                'suggested_reply' => 'Thank you for taking the time to share your review, Sarah! Surviving a 14-hour flight with 40% juice to spare is exactly what we engineered them for. Safe travels!',
                'ai_generated_reply' => 'Thank you for taking the time to share your review, Sarah! Surviving a 14-hour flight with 40% juice to spare is exactly what we engineered them for. Safe travels!',
                'source' => 'google',
                'external_review_id' => 'g-rev-103',
                'created_at' => now()->subHours(10),
            ],
            [
                'reviewer_name' => 'David Miller',
                'product_name' => 'Precision Mechanical Keyboard',
                'rating' => 3,
                'review_text' => 'The typing feel and switches are awesome, but the Bluetooth connection occasionally drops for a second when waking from sleep mode. Firmware update needed.',
                'review_status' => 'pending',
                'processing_status' => 'completed',
                'sentiment' => 'neutral',
                'confidence_score' => 0.840,
                'requires_human_review' => false,
                'ai_summary' => 'Typing feel is praised, but user notes minor Bluetooth reconnection delays after sleep mode.',
                'suggested_reply' => 'Thanks for your honest feedback, David! We are glad you love the switches. Our engineering team has a firmware patch rolling out this month addressing wake-from-sleep latency. Check our support portal or email us for early firmware access!',
                'ai_generated_reply' => 'Thanks for your honest feedback, David! We are glad you love the switches. Our engineering team has a firmware patch rolling out this month addressing wake-from-sleep latency. Check our support portal or email us for early firmware access!',
                'source' => 'shopify',
                'external_review_id' => 'sp-rev-204',
                'created_at' => now()->subDay(),
            ],
            [
                'reviewer_name' => 'Emily Rodriguez',
                'product_name' => '4K UltraHD Streaming Webcam',
                'rating' => 2,
                'review_text' => 'The video sensor is good in bright daylight, but in normal evening room lighting it gets very grainy. The built-in mic also echoes during Zoom calls.',
                'review_status' => 'needs_review',
                'processing_status' => 'completed',
                'sentiment' => 'negative',
                'confidence_score' => 0.910,
                'requires_human_review' => true,
                'ai_summary' => 'User reports low-light graininess and microphone echo during Zoom calls.',
                'suggested_reply' => "Hi Emily, thank you for letting us know. For low-light situations, enabling our companion app's low-light compensation helps significantly. We would also love to inspect your microphone settings to eliminate any echo. Please get in touch with our tech desk!",
                'ai_generated_reply' => "Hi Emily, thank you for letting us know. For low-light situations, enabling our companion app's low-light compensation helps significantly. We would also love to inspect your microphone settings to eliminate any echo. Please get in touch with our tech desk!",
                'source' => 'google',
                'external_review_id' => 'g-rev-105',
                'created_at' => now()->subDays(2),
            ],
            [
                'reviewer_name' => 'Robert Taylor',
                'product_name' => 'Magnetic Fast Wireless Charger 3-in-1',
                'rating' => 5,
                'review_text' => 'Charges iPhone, Apple Watch, and AirPods simultaneously without overheating. Clean design and decluttered my entire nightstand.',
                'review_status' => 'sent',
                'processing_status' => 'completed',
                'sentiment' => 'positive',
                'confidence_score' => 0.990,
                'requires_human_review' => false,
                'ai_summary' => 'Customer is delighted with simultaneous 3-in-1 charging efficiency and clean bedside organization.',
                'suggested_reply' => 'So glad to hear that Robert! A decluttered nightstand makes for much better mornings. Thank you for choosing Caint Electronics!',
                'ai_generated_reply' => 'So glad to hear that Robert! A decluttered nightstand makes for much better mornings. Thank you for choosing Caint Electronics!',
                'source' => 'amazon',
                'external_review_id' => 'amz-rev-301',
                'created_at' => now()->subDays(3),
            ],
            [
                'reviewer_name' => 'Amanda Brooks',
                'product_name' => 'Ergonomic Vertical Mouse',
                'rating' => 4,
                'review_text' => 'Relieved my wrist strain after just 2 days of office work. Takes a couple of hours to get used to the angle, but well worth it.',
                'review_status' => 'approved',
                'processing_status' => 'completed',
                'sentiment' => 'positive',
                'confidence_score' => 0.925,
                'requires_human_review' => false,
                'ai_summary' => 'Customer noted effective wrist pain relief with a brief learning curve.',
                'suggested_reply' => 'Wonderful news Amanda! Ergonomics is our passion, and hearing about your wrist comfort makes our day. Thank you for the review!',
                'ai_generated_reply' => 'Wonderful news Amanda! Ergonomics is our passion, and hearing about your wrist comfort makes our day. Thank you for the review!',
                'source' => 'google',
                'external_review_id' => 'g-rev-107',
                'created_at' => now()->subDays(4),
            ],
            [
                'reviewer_name' => 'Marcus Vance',
                'product_name' => 'Smart Fitness Band V2',
                'rating' => 1,
                'review_text' => 'Heart rate monitor is wildly inaccurate compared to my chest strap. Step count also registered 2000 steps while I was just driving.',
                'review_status' => 'needs_review',
                'processing_status' => 'completed',
                'sentiment' => 'negative',
                'confidence_score' => 0.970,
                'requires_human_review' => true,
                'ai_summary' => 'Severe sensor inaccuracy reported for heart rate tracking and false step detection while driving.',
                'suggested_reply' => 'Hello Marcus, we take sensor accuracy very seriously. Driving vibrations should be filtered out by our motion algorithm. Please ensure your band is on firmware v2.14, or reach out to our team so we can inspect and replace your unit if defective.',
                'ai_generated_reply' => 'Hello Marcus, we take sensor accuracy very seriously. Driving vibrations should be filtered out by our motion algorithm. Please ensure your band is on firmware v2.14, or reach out to our team so we can inspect and replace your unit if defective.',
                'source' => 'shopify',
                'external_review_id' => 'sp-rev-208',
                'created_at' => now()->subDays(5),
            ],
            [
                'reviewer_name' => 'Chloe Bennett',
                'product_name' => 'Noise-Cancelling True Wireless Buds',
                'rating' => 4,
                'review_text' => 'Great soundstage and the transparency mode works well outdoors. The charging case feels a little light in the hand, but otherwise great value.',
                'review_status' => 'pending',
                'processing_status' => 'completed',
                'sentiment' => 'positive',
                'confidence_score' => 0.890,
                'requires_human_review' => false,
                'ai_summary' => 'Good audio soundstage and transparency mode praised; case build feels slightly lightweight.',
                'suggested_reply' => 'Thanks for the review Chloe! We kept the case lightweight for pocket portability, and we are glad you are enjoying the transparency mode and audio fidelity!',
                'ai_generated_reply' => 'Thanks for the review Chloe! We kept the case lightweight for pocket portability, and we are glad you are enjoying the transparency mode and audio fidelity!',
                'source' => 'google',
                'external_review_id' => 'g-rev-109',
                'created_at' => now()->subDays(6),
            ],
            [
                'reviewer_name' => 'Tom H.',
                'product_name' => 'Wireless Gaming Mouse',
                'rating' => 5,
                'review_text' => 'Extremely light, zero click latency, and the battery lasts weeks. Best mouse I have owned for FPS gaming.',
                'review_status' => 'sent',
                'processing_status' => 'completed',
                'sentiment' => 'positive',
                'confidence_score' => 0.995,
                'requires_human_review' => false,
                'ai_summary' => 'Excellent praise for ultra-low latency, light weight, and long battery life in competitive gaming.',
                'suggested_reply' => 'GG Tom! We love hearing how the mouse performs in FPS battles. Thanks for the 5-star support!',
                'ai_generated_reply' => 'GG Tom! We love hearing how the mouse performs in FPS battles. Thanks for the 5-star support!',
                'source' => 'shopify',
                'external_review_id' => 'sp-rev-210',
                'created_at' => now()->subDays(7),
            ],
        ];

        foreach ($demoReviews as $data) {
            $created = Review::create(array_merge($data, ['store_id' => $store->id]));

            // Add history if approved or sent
            if (in_array($created->review_status, ['approved', 'sent'])) {
                ReviewReplyHistory::create([
                    'review_id' => $created->id,
                    'original_reply' => $created->ai_generated_reply,
                    'edited_reply' => $created->suggested_reply,
                    'user_id' => $user->id,
                    'action_type' => $created->review_status === 'sent' ? 'send' : 'approve',
                ]);
            }

            // Create automation log
            AutomationLog::create([
                'review_id' => $created->id,
                'workflow_type' => 'review_analysis',
                'status' => 'completed',
                'payload_data' => json_encode([
                    'review_id' => $created->id,
                    'reviewer' => $created->reviewer_name,
                    'rating' => $created->rating,
                    'sentiment' => $created->sentiment,
                    'confidence' => $created->confidence_score,
                ]),
                'error_message' => null,
                'retry_count' => 0,
                'created_at' => $created->created_at,
            ]);
        }
    }
}
