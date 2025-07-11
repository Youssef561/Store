<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::with('parent')
            ->withcount([
                'products' => function ($query) {
                $query->where('status', '=' , 'active');        // to get the count of only active products
                }
            ])
        ->filter($request->query())->orderBy('name')->paginate(10);         // $request->query()  takes inputs from url

        //$categories = Category::active()->paginate();       // Return only active categories. We can use it if we want to return only active categories, defined in the Category model

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        return view('dashboard.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(Category::rules(), [
            'unique' => 'This category (:attribute) already exists !',      // we can use name.unique if we want to apply the error message for only name input
        ]);

        $validatedData['image'] = $this->uploadImage($request);

        // we use this to send data with request, but this data is not from user
        $validatedData['slug'] = Str::slug($validatedData['name']);

        Category::create($validatedData);

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // == compare values only, ignore data type, will try to convert types if needed '1' == 1 true
        // === Compares both value AND data type, No type conversion, '1' === 1 false you have to use it in auth checks

        $parents = Category::where('id','!=',$category->id)->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate(Category::rules($id));

        $category = Category::findorFail($id);

       $validatedData['image'] = $this->uploadImage($request, $category->image);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        $category->update($validatedData);

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        //Category::destroy($id);
        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category deleted successfully.');
    }



    protected function uploadImage($request, $existingImage = null)
    {
        // Check if the request has a file
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            // If there is an existing image, delete it
            if ($existingImage && file_exists(public_path($existingImage))) {
                unlink(public_path($existingImage));
            }

            // Handle the new image upload
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid('', true) . '.' . $image->getClientOriginalExtension(); // Adding a unique ID for extra safety
            $image->move(public_path('uploads/categories'), $imageName);

            // Return the path to the uploaded image
            return 'uploads/categories/' . $imageName;
        }

        return $existingImage; // Return the existing image if no new file is uploaded
    }

    public function trash(){
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.trash')
            ->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        // after confirm delete, delete the image, caz if delete failed the image still not deleted
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        return redirect()->route('categories.trash')
            ->with('success', 'Category deleted forever.');
    }

}
