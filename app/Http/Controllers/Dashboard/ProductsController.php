<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with(['category','store'])
            ->filter($request->query())
            ->paginate();

        return view('dashboard.products.index', compact('products'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $tags = implode(',',$product->tags()->pluck('name')->toArray());        // add ',' after every name
        return view('dashboard.products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $validatedData = $request->validate(Product::rules($id));
        $product = Product::findOrFail($id);
        $validatedData['image'] = $this->uploadImage($request, $product->image);
        $validatedData['slug'] = Str::slug($validatedData['name']);

        $product->update(Arr::except($validatedData, 'tags'));

        $tagsInput = $request->post('tags', '[]'); // Default to an empty JSON array if missing
        $tags = json_decode($tagsInput) ?? []; // Ensure $tags is always an array

        //$tags = json_decode($request->post('tags'));    // convert the string of json to the value
        $tag_ids = [];

            $saved_tags = Tag::all();

            foreach ($tags as $item) {          // $item is object
                $slug = str::slug($item->value);
                $tag = $saved_tags->where('slug', $slug)->first();
                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $item->value,
                        'slug' => $slug
                    ]);
                }
                $tag_ids[] = $tag->id;
            }

            $product->tags()->sync($tag_ids);       // sync: if the value in array and not in table will add the value if the value already in table does nothing

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    protected function uploadImage($request, $existingImage = null)
    {
        // Check if the request has a file
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            // Delete the old image if it exists in storage
            if ($existingImage && Storage::disk('public')->exists($existingImage)) {
                Storage::disk('public')->delete($existingImage);
            }

            // Store the new image in the 'categories' folder in 'storage/app/public'
            $path = $request->file('image')->store('categories', 'public');

            return $path;
        }

        return $existingImage; // Return the existing image if no new file is uploaded
    }


}
