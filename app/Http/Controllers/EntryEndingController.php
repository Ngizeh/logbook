<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;

class EntryEndingController extends Controller
{
    public function index(string $date)
    {
        $entries = Entry::forWeekEnding($date)->get();

        return response()->json([$entries], 200);;
    }
}
