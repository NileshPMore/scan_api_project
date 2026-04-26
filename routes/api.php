<?php
use Illuminate\Support\Facades\Route;

//Here, I use rate limiting to allow only 10 requests per minute.

Route::post('/scanapidata',[App\Http\Controllers\API\ScanController::class,'scanapidata'])->middleware('throttle:scanapidata');

?>
