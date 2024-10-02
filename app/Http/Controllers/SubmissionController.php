<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $seasonId, int $roundId)
    {
        $submission = Submission::where('user_id', $request->get('user_id'))->where('round_id', $roundId)->first()
            ?? new Submission();
        $submission->user_id = $request->get('user_id');
        $submission->round_id = $request->get('round_id');
        $submission->title = $request->get('title');
        $submission->artist = $request->get('artist');
        $submission->link = $request->get('link');
        $submission->description = $request->get('description');
        $submission->save();

        return redirect()->route('round', ['seasonId' => $seasonId, 'roundId' => $roundId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        //
    }
}
