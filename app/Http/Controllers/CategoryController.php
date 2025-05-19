<?php
namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function categories()
    {
        $categories = Category::where('status', 1)->get();
        return CategoryResource::collection($categories);
    }

    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return CategoryResource::collection($categories);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string',
            'logo'   => 'nullable|file|image|mimes:jpg,jpeg,png,svg|max:2048',
            'status' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            $path              = $request->file('logo')->store('category-logo', 'public');
            $validated['logo'] = $path;
        }

        $category = Category::create($validated);

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return CategoryResource::make($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'   => 'sometimes|required|string',
            'logo'   => 'nullable|file|image|mimes:jpg,jpeg,png,svg|max:2048',
            'status' => 'nullable|integer',
        ]);
        $path = null;
        if ($request->hasFile('logo')) {
            if ($category->logo && Storage::disk('public')->exists($category->logo)) {
                Storage::disk('public')->delete($category->logo);
            }
            $path = $request->file('logo')->store('category-logo', 'public');
        }
        $category->update([
            'name'   => $request->name ?? $category->name,
            'status' => $request->status ?? $category->status,
            'logo'   => $path ?? $category->logo,
        ]);

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->logo && Storage::disk('public')->exists($category->logo)) {
            Storage::disk('public')->delete($category->logo);
        }
        $category->delete();
        return response()->json([
            'message' => 'Category Deleted!',
        ], 200);
    }
}
