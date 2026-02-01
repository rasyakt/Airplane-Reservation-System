<?php
// Load Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Airport;

$sin = Airport::where('iata_airport_code', 'SIN')->first();
$cgk = Airport::where('iata_airport_code', 'CGK')->first();

echo "SIN Code: [" . ($sin->iata_country_code ?? 'NULL') . "]\n";
echo "CGK Code: [" . ($cgk->iata_country_code ?? 'NULL') . "]\n";

if ($sin && $cgk) {
    $isDomestic = ($sin->iata_country_code == 'ID' && $cgk->iata_country_code == 'ID');
    echo "Is Domestic check (SIN-CGK): " . ($isDomestic ? "YES" : "NO") . "\n";
}

use App\Models\Flight;
$flight = Flight::with('schedule')->where('flight_call', 'like', 'GA202%')->first();
if ($flight) {
    echo "\nFlight: " . $flight->flight_call . "\n";
    echo "Origin: " . $flight->schedule->origin_iata_airport_code . "\n";
    echo "Dest: " . $flight->schedule->dest_iata_airport_code . "\n";
} else {
    echo "\nFlight not found.\n";
}
