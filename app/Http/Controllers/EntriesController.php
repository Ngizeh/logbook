<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Http\Requests\EntryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EntriesController extends Controller
{
	/**
	 * List of the resource to display
	 *
	 * @return View 
	 */
	public function index()
	{
		$entries = Entry::all();

		return view('entries.index', compact('entries'));
	}

   /**
	* Show a form to create a resource
	*
	* @return  View 
	*/
	public function create()
	{
		return view('entries.create');
	}

	/**
	 * Create a resource from a form request
	 *
	 * @param   EntryRequest  $request  Form Request Validatation
	 *
	 * @return  RedirectResponse Redirect Response
	 */
	public function store(EntryRequest $request) : RedirectResponse
	{
		$data = $request->all();

		Entry::create($data);

		return redirect()->to(route('entries.index'));
	}

	/**
	 * Edit a specified resource from the Route model binding
	 *
	 * @param   Entry  $entry
	 *
	 * @return View
	 */
	public function edit(Entry $entry): View
	{
		return view('entries.edit', compact('entry'));
	}
    
	/**
	 * Update a specific resource
	 *
	 * @param   EntryRequest  $request  
	 * @param   Entry         $entry    
	 * @return  RedirectResponse                 
	 */
	public function update(EntryRequest $request, Entry $entry) :  RedirectResponse 
	{
		$entry->update($request->only(['title', 'description', 'type']));

		return redirect()->to(route('entries.show', $entry));
	}
	
	/**
	 * Show a specified resource
	 *
	 * @param   Entry  $entry 
	 *
	 * @return View 
	 */
	public function show(Entry $entry) : View
	{
		return view('entries.show', compact('entry'));
	}

	public function destroy(Entry $entry)
	{
		$entry->delete();

		return redirect()->to(route('entries.index'));
	}
	
}
