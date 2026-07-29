<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\AcademicYear;
use App\Models\Enrollment;
use App\Models\Promotion;

$year = AcademicYear::where('name','2025-2026')->first();
$promoNames = ['D2','D3','M2'];
foreach ($promoNames as $name) {
    $promo = Promotion::where('name',$name)->first();
    if (!$promo) { echo "$name: no promotion\n"; continue; }
    $enrollments = Enrollment::with(['user','promotion','academicYear','department'])
        ->where('promotion_id',$promo->id)
        ->where('academic_year_id',$year->id)
        ->get();
    echo "\n$name (2025-2026) count=".$enrollments->count()."\n";
    foreach ($enrollments as $enrollment) {
        echo $enrollment->user->name.' | '.$enrollment->status.' | '.$enrollment->department->name.' | year '.$enrollment->academicYear->name."\n";
    }
}
