<?php

namespace App\Http\Controllers;

use App\Category;
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
	public function store(EntryRequest $request)
	{
		$data = $request->all();

		Entry::create($data);

		return response()->json([], 201);
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
	public function update(EntryRequest $request, Entry $entry)
	{
		$entry->update($request->only(['title', 'description', 'category_id']));

		return response()->json([], 201);
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
     * @return Response
     * @throws \Exception
     */
	public function destroy(Entry $entry)
    {
		$entry->delete();

		return response()->json([$entry], 202);
	}

    /**
     * Get Dates for the weeks entries
     * @return array
     */
    private function getDates()
    {
        $oldest = Entry::oldest()->first();

        $dateFormat = 'F j, Y';

		$now = now()->endOfWeek()->format($dateFormat);

        if(!$oldest){
            return [$now];
        }

        $oldest = $oldest->created_at->endOfWeek();
        $latest = Entry::latest()->first()->created_at->endOfWeek();
        $diff = $oldest->diffInWeeks($latest);

        $dates = [];
        $currentDate = $latest;
        for($i = $diff; $i >= 0; $i--){
            $dates[] = $currentDate->format($dateFormat);
            $currentDate = $currentDate->copy()->subWeek();
        }

		if($now !== $dates[0]) {
			array_unshift($dates, $now);
		}

        return $dates;
    }

}
