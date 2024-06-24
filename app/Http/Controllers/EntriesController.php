<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entry;
use App\Http\Requests\EntryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class EntriesController extends Controller
{
    /**
     * List of the resource to display
     *
     * @return array|View
     */
    public function index()
    {
        $weekly = Entry::forThisWeek()->latest()->get();
        $dates = $this->getDates();

        if (request()->wantsJson()) {
            return [$weekly, $dates];
        }

        return view('entries.index', [
            'weeklyEntries' => $weekly,
            'entriesDate' => $dates,
        ]);
    }

    /**
     * Show a form to create a resource
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('entries.create', compact('categories'));
    }

    /**
     * Create a resource from a form request
     *
     * @param  EntryRequest  $request  Form Request Validation
     * @return JsonResponse Response
     */
    public function store(EntryRequest $request): JsonResponse
    {
        $data = $request->all();

        Entry::create($data);

        return response()->json([], 201);
    }

    /**
     * Edit a specified resource from the Route model binding
     */
    public function edit(Entry $entry): View
    {
        $categories = Category::all();

        return view('entries.edit', compact('entry', 'categories'));
    }

    /**
     * Update a specific resource
     *
     * @return JsonResponse
     */
    public function update(EntryRequest $request, Entry $entry)
    {
        $entry->update($request->only(['title', 'description', 'category_id']));

        return response()->json([], 201);
    }

    /**
     * Show a specified resource
     */
    public function show(Entry $entry): View
    {
        return view('entries.show', compact('entry'));
    }

    /**
     * @throws \Exception
     */
    public function destroy(Entry $entry): JsonResponse
    {
        $entry->delete();

        return response()->json([$entry], 202);
    }

    /**
     * Get Dates for the weeks entries
     */
    private function getDates(): Collection
    {
        $oldest = Entry::oldest()->first();

        $dateFormat = 'F j, Y';

        $now = now()->endOfWeek()->format($dateFormat);

        if (! $oldest) {
            return collect($now);
        }

        $oldest = $oldest->created_at->endOfWeek();
        $latest = Entry::latest()->first()->created_at->endOfWeek();
        $diff = $oldest->diffInWeeks($latest);

        $dates = [];
        $currentDate = $latest;
        for ($i = $diff; $i >= 0; $i--) {
            $dates[] = $currentDate->format($dateFormat);
            $currentDate = $currentDate->copy()->subWeek();
        }

        if ($now !== $dates[0]) {
            array_unshift($dates, $now);
        }

        return collect($dates);
    }
}
