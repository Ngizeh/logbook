<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Http\Requests\EntryRequest;
use Illuminate\Http\Request;

class EntriesController extends Controller
{
    public function store(EntryRequest $request)
    {
    	$data = $request->all();

        Entry::create($data);

        return response()->json([], 201);
    }
}
