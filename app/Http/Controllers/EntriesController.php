<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entry;
use App\Http\Requests\EntryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class EntriesController extends Controller
{
    /**
     * List of the resource to display
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $weeklyEntries = Entry::forThisWeek()->latest()->get();
        $entriesDate = $this->getDates();

        return Inertia::render('Index', compact('weeklyEntries', 'entriesDate'));
    }

    /**
     * Show a form to create a resource
     *
     * @return  Response
     */
    public function create(): Response
    {
        $categories =  Category::all();

        return Inertia::render('Create', compact('categories'));

    }

    /**
     * Create a resource from a form request
     *
     * @param   EntryRequest  $request  Form Request Validation
     *
     * @return  RedirectResponse Response
     */
    public function store(EntryRequest $request): RedirectResponse
    {
        $data = $request->all();

        Entry::create($data);

        return Redirect::route('entries.index');
    }

    /**
     * Edit a specified resource from the Route model binding
     *
     * @param   Entry  $entry
     *
     * @return Response
     */
    public function edit(Entry $entry): Response
    {
        $categories = Category::all();

        return Inertia::render('Edit', compact('entry', 'categories'));
    }

    /**
     * Update a specific resource
     *
     * @param   EntryRequest  $request
     * @param   Entry         $entry
     * @return  RedirectResponse
     */
    public function update(EntryRequest $request, Entry $entry): RedirectResponse
    {
        $entry->update($request->only(['title', 'description', 'category_id']));

        return Redirect::route('entries.index');
    }

    /**
     * Show a specified resource
     *
     * @param   Entry  $entry
     *
     * @return Response
     */
    public function show(Entry $entry) : Response
    {
        return Inertia::render('entries.show', compact('entry'));
    }

    /**
     * @param Entry $entry
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Entry $entry): JsonResponse
    {
        $entry->delete();

        return response()->json([$entry], 202);
    }

    /**
     * Get Dates for the weeks entries
     * @return Collection
     */
    private function getDates(): Collection
    {
        $oldest = Entry::oldest()->first();

        $dateFormat = 'F j, Y';

        $now = now()->endOfWeek()->format($dateFormat);

        if(!$oldest){
            return collect($now);
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
        return collect($dates);
    }

}
