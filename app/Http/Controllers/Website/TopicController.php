<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function show($slug)
    {
        $topic = Topic::where('slug', $slug)
            ->with('subtopics') // eager load subtopics
            ->firstOrFail();

        return view('topics.show', compact('topic'));
    }
}
