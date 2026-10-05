<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('admin.categories.create');
    }

    // Menyimpan kategori
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:categories,name',
        'description' => 'nullable',
        'status' => 'required|in:aktif,nonaktif',
    ]);

    Category::create([
        'name' => $request->name,
        'description' => $request->description,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('categories.index')
        ->with('success', 'Kategori berhasil ditambahkan.');
}

    // Menampilkan form edit
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Update kategori
  public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|unique:categories,name,' . $category->id,
        'description' => 'nullable',
        'status' => 'required|in:aktif,nonaktif',
    ]);

    $category->update([
        'name' => $request->name,
        'description' => $request->description,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('categories.index')
        ->with('success', 'Kategori berhasil diperbarui.');
}
    // Hapus kategori
    public function destroy(Category $category)
{
    $category->delete();

    return redirect()
        ->route('categories.index')
        ->with('success', 'Kategori berhasil dihapus.');
}
}