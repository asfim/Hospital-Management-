<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'id' => 1,
                'name' => 'Nadia Sultana',
                'location' => 'Dhanmondi, Dhaka',
                'rating' => 5,
                'photo' => 'testimonials/9ZACug9wWqyB5xXJg0rK1vohbZFE6hk58X3uMbsf.jpg',
                'review' => 'The care and clinical precision here exceeded all our expectations. My mother was admitted for an emergency cardiology evaluation, and within minutes the team performed complete diagnostics with remarkable professionalism. The nursing staff was attentive around the clock, and the online test reports arrived on our phone within hours. Truly a lifesaver hospital!',
                'status' => true,
            ],
            [
                'id' => 2,
                'name' => 'Farzana Rahman',
                'location' => 'Uttara Sector 7, Dhaka',
                'rating' => 5,
                'photo' => 'testimonials/tkunwhxjLPMsnikuwZhkPsX8lyivXLOCNu6YgWa9.webp',
                'review' => 'Delivering our baby here was the most comforting experience. The Gynecology & Obstetrics consultants, the spotless VIP cabin, and the 24/7 neonatal intensive care team provided complete peace of mind. Every nurse treated us like family, and the post-natal guidance was invaluable. I wholeheartedly recommend this hospital to all expectant mothers.',
                'status' => true,
            ],
            [
                'id' => 3,
                'name' => 'Prof. Dr. Tahmina Akhter',
                'location' => 'Gulshan-1, Dhaka',
                'rating' => 5,
                'photo' => 'testimonials/AwjcnLo2eqhtm0Umhl1VrZih20Q0jpOb6n4KfYqI.jpg',
                'review' => 'As a healthcare researcher, I am very discerning about diagnostic accuracy. The 3T MRI, 128-slice CT scan, and automated biochemistry lab at this facility meet rigorous international accreditation standards. The consultant physicians take real time to explain findings and listen to patient concerns. Cleanliness and clinical governance are commendable.',
                'status' => true,
            ],
            [
                'id' => 4,
                'name' => 'Master Ahyan & Tariqul Islam (Father)',
                'location' => 'Banani, Dhaka',
                'rating' => 5,
                'photo' => 'testimonials/kPeP3GtG5ZKHgZElhWkKGUe4cybYWX46KzJ1blvY.jpg',
                'review' => 'When my 5-year-old son suddenly came down with high fever and respiratory distress at midnight, the Pediatric Emergency team was extraordinary. The doctors calmed him down, administered nebulization gently, and within 30 minutes his vitals were stable. A genuinely child-friendly hospital environment with the most caring pediatricians.',
                'status' => true,
            ],
            [
                'id' => 5,
                'name' => 'Engr. Tanvir Ahmed',
                'location' => 'Mirpur DOHS, Dhaka',
                'rating' => 5,
                'photo' => 'testimonials/VmvWNQPFcZSLVst006RtK0FpTS1NazRakGZr74XF.jpg',
                'review' => 'Underwent a minimally invasive laparoscopic surgery here last month. The digital pre-anesthesia checkup, state-of-the-art modular OT, and rapid recovery protocol allowed me to walk comfortably the very next day. Transparent billing with zero hidden costs and seamless digital discharge summary. This hospital sets a gold standard for healthcare.',
                'status' => true,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
        }
    }
}
