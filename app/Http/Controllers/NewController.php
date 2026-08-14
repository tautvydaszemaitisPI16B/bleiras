<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewRequest;
use App\Models\News;
use Illuminate\Http\JsonResponse;


class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $news = News::query()
            ->latest('published_at')
            ->paginate(6);

        return response()->json([
            'data' => $news,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewRequest $request): JsonResponse
    {
        $news = News::create($request->validated());

        return response()->json([
            'data' => $news,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news): JsonResponse
    {
        return response()->json([
            'data' => $news,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewRequest $request, News $news): JsonResponse {
        $news->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Naujiena atnaujinta.',
            'data' => $news->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news): JsonResponse
    {
        $news->delete();

        return response()->json([
            'message' => 'Naujiena ištrinta.',
        ]);
    }
}
