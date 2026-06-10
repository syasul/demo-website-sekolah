<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = \App\Models\Article::with('author')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'category' => 'required|string',
        ]);

        $article = new \App\Models\Article();
        $article->title = $request->title;
        $article->slug = \Illuminate\Support\Str::slug($request->title) . '-' . time();
        $article->content = $request->content;
        $article->category = $request->category;
        $article->author_id = auth()->id();

        if ($request->hasFile('image')) {
            $article->image = $request->file('image')->store('articles', 'public');
        }

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil diterbitkan.');
    }

    public function edit(string $id)
    {
        $article = \App\Models\Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'category' => 'required|string',
        ]);

        $article = \App\Models\Article::findOrFail($id);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->category = $request->category;

        if ($request->hasFile('image')) {
            $article->image = $request->file('image')->store('articles', 'public');
        }

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $article = \App\Models\Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil dihapus.');
    }

}
