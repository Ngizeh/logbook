<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entry;
use App\Http\Requests\EntryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
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

    	$entries = Entry::forThisWeek()->latest()->get();
    	$dates = $this->getDates();

    	if(request()->wantsJson()){
    		return [$entries, $dates];
    	}
		return view('entries.index', [
		    'entries' => $entries,
            'entriesDate' => $this->getDates()
        ]);
	}

   /**
	* Show a form to create a resource
	*
	* @return  View
	*/
	public function create(): View
    {
		$categories =  Category::all();

		return view('entries.create', compact('categories'));
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
		$categories = Category::all();

		return view('entries.edit', compact('entry', 'categories'));
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
		$entry->update($request->only(['title', 'description', 'category_id']));

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

    /**
     * @param Entry $entry
     * @return RedirectResponse
     * @throws \Exception
     */
	public function destroy(Entry $entry)
    {
		$entry->delete();

		return response()->json([$entry], 202);

		// return redirect()->to(route('entries.index'));
	}

    /**
     * Get Dates for the weeks entries
     * @return Collection
     */
    private function getDates(): \Illuminate\Support\Collection
    {
        $oldest = Entry::oldest()->first();

        $dateFormat = 'F j, Y';

        if(!$oldest){
            return collect(now()->endOfWeek()->format($dateFormat));
        }

        $oldest = $oldest->created_at->endOfWeek();
        $latest = Entry::latest()->first()->created_at->endOfWeek();
        $diff = $oldest->diffInWeeks($latest) + 1;

        $dates = [];
        $currentDate = $latest;
        for($i = $diff; $i >= 0; $i--){
            $dates[] = $currentDate->format($dateFormat);
            $currentDate = $currentDate->copy()->subWeek();
        }

        return collect($dates);
    }

}
