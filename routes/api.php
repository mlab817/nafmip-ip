<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/investments', function (Request $request) {
    $province = \App\Models\Province::find($request->province);

    $investments = [];

    if ($province) {
        $investments = \App\Models\Investment::within('location_map', $province->geometry)->get();
    } else {
        $investments = \App\Models\Investment::paginate();
    }

    return \App\Http\Resources\InvestmentResource::collection($investments);
});
