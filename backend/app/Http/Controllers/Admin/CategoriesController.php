<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post)
    {
        $this->category = $category;
        $this->post = $post;
    }

    public function index()
    {
        $all_categories = $this->category->orderBy('updated_at', 'desc')->paginate(10);

        $uncategorized_count = 0;
        $all_posts = $this->post->all();
        foreach($all_posts as $post){
            if ($post->categoryPost->count() == 0) {
                $uncategorized_count++;
            }

        }
        return view('admin.categories.index')->with('all_categories', $all_categories)->with('uncategorized_count', $uncategorized_count);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:50']);
        $this->category->name = ucfirst($request->name);
        $this->category->slug = str_replace(' ', '-', strtolower($request->name));
        $this->category->save();

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|max:50']);

        $category = $this->category->findOrFail($id);
        $category->name = ucfirst($request->name);
        $category->slug = str_replace(' ', '-', strtolower($request->name));
        $category->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->category->destroy($id);
        return redirect()->back();
    }
}
