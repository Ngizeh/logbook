<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Http\Requests\EntryRequest;
use Illuminate\Http\Request;

class EntriesController extends Controller
{
	public function index()
	{
		$entries = Entry::all();

		return view('entries.index', compact('entries'));
	}

	public function create()
	{
		return view('entries.create');
	}

	public function store(EntryRequest $request)
	{
		$data = $request->all();

		Entry::create($data);

		return redirect()->to(route('entries.index'));
	}


	public function show(Entry $entry)
	{
		return view('entries.show', compact('entry'));
	}

}
