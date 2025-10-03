<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Note::query()->orderBy('created_at', 'desc');

        // Filter by topic
        if ($request->has('topic') && $request->topic) {
            $query->byTopic($request->topic);
        }

        // Filter by sub topic
        if ($request->has('sub_topic') && $request->sub_topic) {
            $query->bySubTopic($request->sub_topic);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $notes = $query->paginate(12);

        // Get all unique topics and sub topics for filters
        $topics = Note::distinct()->pluck('topic');
        $subTopics = Note::distinct()->pluck('sub_topic')->filter();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $notes,
                'topics' => $topics,
                'sub_topics' => $subTopics
            ]);
        }

        return view('notes.index', compact('notes', 'topics', 'subTopics'));
    }

    /**
     * Store a newly created note
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'sub_topic' => 'nullable|string|max:255',
            'content' => 'required|string',
            'description' => 'nullable|string|max:500',
            'components_used' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Count components in content
        $componentCount = $this->countComponents($request->content);

        // Extract components used
        $componentsUsed = $this->extractComponentsUsed($request->content);

        $note = Note::create([
            'topic' => $request->topic,
            'sub_topic' => $request->sub_topic,
            'content' => $request->content,
            'description' => $request->description,
            'components_used' => $componentsUsed,
            'component_count' => $componentCount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note saved successfully!',
            'data' => $note
        ], 201);
    }

    /**
     * Display the specified note
     */
    public function show($id)
    {
        $note = Note::findOrFail($id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $note
            ]);
        }

        return view('notes.show', compact('note'));
    }

    /**
     * Update the specified note
     */
    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'sub_topic' => 'nullable|string|max:255',
            'content' => 'required|string',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Count components in content
        $componentCount = $this->countComponents($request->content);

        // Extract components used
        $componentsUsed = $this->extractComponentsUsed($request->content);

        $note->update([
            'topic' => $request->topic,
            'sub_topic' => $request->sub_topic,
            'content' => $request->content,
            'description' => $request->description,
            'components_used' => $componentsUsed,
            'component_count' => $componentCount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully!',
            'data' => $note
        ]);
    }

    /**
     * Remove the specified note
     */
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully!'
        ]);
    }

    /**
     * Get all topics
     */
    public function getTopics()
    {
        $topics = Note::distinct()->pluck('topic');

        return response()->json([
            'success' => true,
            'data' => $topics
        ]);
    }

    /**
     * Get sub topics by topic
     */
    public function getSubTopics($topic)
    {
        $subTopics = Note::where('topic', $topic)
            ->distinct()
            ->pluck('sub_topic')
            ->filter();

        return response()->json([
            'success' => true,
            'data' => $subTopics
        ]);
    }

    /**
     * Get statistics
     */
    public function statistics()
    {
        $stats = [
            'total_notes' => Note::count(),
            'total_topics' => Note::distinct('topic')->count(),
            'total_components' => Note::sum('component_count'),
            'recent_notes' => Note::orderBy('created_at', 'desc')->take(5)->get(),
            'popular_components' => $this->getPopularComponents(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Count components in HTML content
     */
    private function countComponents($content)
    {
        return substr_count($content, 'component-wrapper');
    }

    /**
     * Extract which components were used
     */
    private function extractComponentsUsed($content)
    {
        $components = [];

        // Extract data-component-type attributes
        preg_match_all('/data-component-type="([^"]+)"/', $content, $matches);

        if (!empty($matches[1])) {
            $components = array_unique($matches[1]);
        }

        return $components;
    }

    /**
     * Get popular components statistics
     */
    private function getPopularComponents()
    {
        $allComponents = Note::pluck('components_used')->flatten()->toArray();
        $componentCounts = array_count_values($allComponents);
        arsort($componentCounts);

        return array_slice($componentCounts, 0, 10, true);
    }
}
