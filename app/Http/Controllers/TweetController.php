<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tweet;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Faker\Provider\DateTime as ProviderDateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use IntlCalendar;
use IntlTimeZone;
use Locale;
use NunoMaduro\Collision\Adapters\Phpunit\Timer;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        return view('tweets.index', [
            'tweets' => Tweet::with('user')->with('comments')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required',
        ]);

        $request->user()->tweets()->create($validated);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function show(Tweet $tweet)
    {
        $comments = Comment::with('user')->where('tweet_id', $tweet->id)->latest()->get();
        // dd($comments, $tweet);
        return view('tweets.show', compact('tweet', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tweet $tweet)
    {
        $this->authorize('update', $tweet);

        $validated = $request->validate([
            'content' => 'required'
        ]);

        $tweet->update($validated);

        return redirect()->route('tweets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        $this->authorize('delete', $tweet);

        $tweet->delete();

        return redirect()->back();
    }
}
