<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->route()->named('categories.index')) {

            $categories = Category::all();
            return view('categories.index', compact('categories'));
        } else {

            $categories = Category::whereHas('products', function ($query) {
                $query->where('stock', '>', 0);
            })->with(['products' => function ($query) {
                $query->where('stock', '>', 0);
            }])->get();

            return view('home', compact('categories'));
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'La categoría se creo exitosamente');
    }

    public function show($id)
    {
        $category = Category::with(['products' => function ($query) {
            $query->where('stock', '>', 0);
        }])->findOrFail($id);

        return view('categories.show', compact('category'));
    }

    public function showProducts(Category $category)
    {
        $products = $category->products()->where('stock', '>', 0)->get();
        return view('categories.show', compact('category', 'products'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'La categoría se actualizo correctamente.');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('categories.index')->with('success', 'La categoría se elimino correctamente.');
    }
}