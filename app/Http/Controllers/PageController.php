<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $pages = [
            'about' => [
                'title' => 'About Us',
                'content' => 'AirlineBooking is your premier partner for seamless air travel. Established in 2024, we connect you to over 50 destinations worldwide with the best prices and superior service. Our mission is to make flying accessible, comfortable, and memorable for everyone.',
                'icon' => 'fas fa-plane-departure'
            ],
            'contact' => [
                'title' => 'Contact Us',
                'content' => 'Have questions? We are here to help! \n\nEmail: support@airlinebooking.com\nPhone: +62 21 555 1234\nAddress: Soekarno-Hatta International Airport, Terminal 3, Jakarta, Indonesia.',
                'icon' => 'fas fa-headset'
            ],
            'terms' => [
                'title' => 'Terms of Service',
                'content' => '1. By using this website, you agree to these terms.\n2. All bookings are subject to availability.\n3. Cancellations must be made 24 hours in advance.\n4. Prices include all applicable taxes.',
                'icon' => 'fas fa-file-contract'
            ],
            'privacy' => [
                'title' => 'Privacy Policy',
                'content' => 'We value your privacy. All personal data collected during booking is encrypted and used solely for transaction purposes. We do not sell your data to third parties.',
                'icon' => 'fas fa-user-shield'
            ]
        ];

        if (!array_key_exists($slug, $pages)) {
            abort(404);
        }

        return view('pages.show', ['page' => $pages[$slug]]);
    }
}
