<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Mengambil semua data post dan category
            $posts = Post::all();
            $categories = Category::all();

            // Periksa apakah permintaan tersebut adalah permintaan API atau permintaan web
            if ($request->is('api/*')) {
                // Mengembalikan respons JSON untuk permintaan API
                return response()->json([
                    'posts' => $posts,
                    'categories' => $categories,
                ], 200);
            } else {
                //Mengembalikan tampilan untuk permintaan web
                return view('posts.index', compact('posts', 'categories'));
            }
        } catch (\Exception $e) {
            // Menangani pengecualian dan mengembalikan kesalahan terperinci
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        $categories = Category::all(); // Ambil data kategori
        return view('posts.create', compact('categories')); // Kirim ke view
    }

    public function store(Request $request)
    {
        try {
            // validasi data
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'category_id' => 'required|exists:categories,id',
            ]);

            // Buat postingan dengan data yang tervalidasi
            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
            ]);

            // Periksa apakah permintaan mengharapkan respons JSON (permintaan API)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Postingan berhasil dibuat',
                    'post' => $post,
                ], 201);
            }

            // Redirect for web requests
            return redirect()->route('posts.index')->with('success', 'Postingan berhasil dibuat.');

        } catch (\Exception $e) {
            // Return error response for API requests
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }

            // Redirect back with errors for web requests
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id, Request $request)
    {
        try {
            // Temukan postingan berdasarkan ID beserta kategori terkaitnya
            $post = Post::with('category')->findOrFail($id);

            // Periksa apakah permintaan mengharapkan respons JSON (permintaan API)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Postingan berhasil diambil',
                    'post' => $post,
                ], 200);
            }

            // Return a view for web requests
            return view('posts.show', compact('post'));

        } catch (\Exception $e) {
            // Handle error
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Post not found',
                    'message' => $e->getMessage(),
                ], 404);
            }

            return redirect()->back()->withErrors(['error' => 'Post not found']);
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'category_id' => 'required|exists:categories,id',
            ]);

            // Temukan postingan dengan ID atau lempar 404
            $post = Post::findOrFail($id);

            // Perbarui postingan dengan data yang divalidasi
            $post->update($validated);

            // Mengembalikan respons JSON jika itu adalah permintaan API (mengharapkan JSON)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Post updated successfully',
                    'post' => $post,
                ], 200);
            }

            // Redirect for web requests
            return redirect()->route('posts.index')->with('success', 'Post updated successfully');

        } catch (\Exception $e) {
            // Return error response for API request
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }

            // Return error for web request
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    // return redirect()->route('posts.index')->with('success', 'Post updated successfully');

    public function destroy($id, Request $request)
    {
        try {
            // Find the post by ID
            $post = Post::findOrFail($id);

            // Delete the post
            $post->delete();

            // Periksa apakah permintaan untuk API (mengharapkan JSON)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Postingan berhasil dihapus',
                ], 200);
            }

            // Untuk permintaan web, alihkan kembali ke posts.index dengan pesan sukses
            return redirect()->route('posts.index')->with('success', 'Postingan berhasil dihapus.');

        } catch (\Exception $e) {
            // Menangani kesalahan untuk posting tidak ditemukan atau kegagalan penghapusan
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Post not found or failed to delete',
                    'message' => $e->getMessage(),
                ], 404);
            }
            return redirect()->route('posts.index')->with('error', 'Postingan berhasil dihapus');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        // Lakukan pencarian posts berdasarkan title atau content
        $posts = Post::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->get();

        // Dapatkan semua categories
        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

}
