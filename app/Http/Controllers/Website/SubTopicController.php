<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\SubTopic;
use Illuminate\Http\Request;

class SubTopicController extends Controller
{
    public function show($topicSlug, $subtopicSlug)
    {
        $subtopic = SubTopic::where('slug', $subtopicSlug)
            ->with('contents') // eager load contents
            ->firstOrFail();

        return view('subtopics.show', compact('subtopic'));
    }
}
