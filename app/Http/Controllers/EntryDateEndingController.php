<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;

class EntryEndingController extends Controller
{
    public function weekending(string $date)
    {
        $entries = Entry::forWeekEnding($date)->get();

        return response()->json([$entries], 200);;
    }
}