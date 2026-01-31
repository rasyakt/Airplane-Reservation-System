<x-mail::message>
    # Booking Confirmation

    Dear {{ $booking->client->name }},

    Thank you for booking with {{ config('app.name') }}. Your booking has been successfully confirmed.

    **Confirmation Code:** #{{ $booking->confirmation_code }}

    ### Flight Details
    - **From:** {{ $booking->flight->schedule->originAirport->city }}
    ({{ $booking->flight->schedule->originAirport->iata_airport_code }})
    - **To:** {{ $booking->flight->schedule->destinationAirport->city }}
    ({{ $booking->flight->schedule->destinationAirport->iata_airport_code }})
    - **Date:** {{ $booking->flight->schedule->departure_time_gmt->format('D, d M Y') }}
    - **Departure:** {{ $booking->flight->schedule->departure_time_gmt->format('H:i') }} GMT
    - **Seat:** {{ $booking->seat->seat_number }} ({{ $booking->seat->travelClass->name }})

    <x-mail::button :url="route('bookings.confirmation', $booking->confirmation_code)">
        View Ticket Details
    </x-mail::button>

    Safe travels,<br>
    {{ config('app.name') }}
</x-mail::message>