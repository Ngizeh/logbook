<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EntryDateEndingController extends Controller
{
    public function weekending(string $date): JsonResponse
    {
        $entries = Entry::forWeekEnding($date)->get();

        return response()->json([$entries], 200);
    }

    public function dayEnding(string $date)
    {
        $entries = Entry::forDay($date)->get();

        return response()->json([$entries], 200);
    }
}
