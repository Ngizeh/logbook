<?php

namespace App\Http\Controllers;

use App\Entry;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EntryDateEndingController extends Controller
{
    public function weekending(string $date): JsonResponse
    {
        $weekly = Entry::forWeekEnding($date)->get();

        return response()->json([$weekly], 200);
    }

    public function dayEnding(string $date): JsonResponse
    {
        $daily = Entry::forDay($date)->get();

        return response()->json([$daily], 200);
    }
}
