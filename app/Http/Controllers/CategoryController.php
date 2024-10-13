<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil semua kategori
        try {
            $categories = Category::all();
            return response()->json($categories);
        } catch (\Exception $e) {
            // Menangani pengecualian dan mengembalikan kesalahan terperinci
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input untuk kategori
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Simpan kategori ke dalam database
            $category = Category::create([
                'name' => $request->name,
            ]);

            // Menangani respons berdasarkan tipe request (Web atau API)
            if ($request->expectsJson()) {
                return response()->json($category, 201); // Respons untuk API
            } else {
                return redirect()->route('posts.index')->with('success', 'Category created successfully.'); // Respons untuk Web
            }

        } catch (ValidationException $e) {
            // Jika terjadi error validasi, kirim respons error
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Validation failed.',
                    'details' => $e->errors(),
                ], 422); // Status code 422 untuk validasi gagal
            }

            // Jika Web, kembali dengan error
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Tangani exception lain jika ada kesalahan lain
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Something went wrong!',
                    'details' => $e->getMessage(),
                ], 500); // Status code 500 untuk kesalahan server
            }
            // Tampilkan error di Web jika ada kesalahan server
            return back()->with('error', 'Something went wrong!')->withInput();
        }
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id) // Terima ID dari URL
    {
        try {
            // Validasi request
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Temukan kategori berdasarkan ID
            $category = Category::findOrFail($id);

            // Update kategori
            $category->update([
                'name' => $request->name,
            ]);
            // Menangani permintaan JSON (API)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Category updated successfully',
                    'category' => $category,
                ], 200);
            }
            // Menangani permintaan Web (redirect ke posts.index)
            return redirect()->route('posts.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            // Menangani error jika kategori tidak ditemukan atau gagal diperbarui

            // Menangani permintaan JSON (API)
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Category not found or failed to update',
                    'message' => $e->getMessage(),
                ], 404);
            }
            // Menangani permintaan Web (redirect ke posts.index)
            return redirect()->route('posts.index')->with('error', 'Category not found or failed to update.');
        }
    }
    public function show($id, Request $request)
    {
        try {
            // Mencari kategori berdasarkan ID
            $category = Category::findOrFail($id);

            // Menangani permintaan JSON (API)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Category found',
                    'category' => $category,
                ], 200);
            }
            // Menangani permintaan Web (mengembalikan view dengan data kategori)
            return view('categories.show', compact('category'));
        } catch (\Exception $e) {
            // Menangani kasus jika kategori tidak ditemukan

            // Menangani permintaan JSON (API)
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Category not found',
                    'message' => $e->getMessage(),
                ], 404);
            }
            // Menangani permintaan Web (mengalihkan ke halaman index dengan error)
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }
    }

    public function destroy($id, Request $request) // Terima ID sebagai parameter
    {
        try {
            // Mengambil kategori berdasarkan ID
            $category = Category::findOrFail($id);
            // Menghapus kategori
            $category->delete();
            // Menangani permintaan JSON (API)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Category deleted successfully',
                ], 200);
            }

            // Menangani permintaan Web (redirect ke posts.index)
            return redirect()->route('posts.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            // Menangani error jika kategori tidak ditemukan atau gagal dihapus

            // Menangani permintaan JSON (API)
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Category not found or failed to delete',
                    'message' => $e->getMessage(),
                ], 404);
            }
            // Menangani permintaan Web (redirect ke posts.index)
            return redirect()->route('posts.index')->with('error', 'Category not found or failed to delete.');
        }
    }

}
