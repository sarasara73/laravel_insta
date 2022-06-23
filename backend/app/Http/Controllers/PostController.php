<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/images/';
    private $post;
    private $category;

    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }

    public function create()
    {
        $all_categories = $this->category->get();

        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request)
    {
        #validate the request
        $request->validate([
            'category'    => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image'       => 'required|mimes:jpg,png,jpeg,gif|max:1048'
        ]); //Multpurpose Internet Mail Extentions

        #save the post
        $this->post->user_id = Auth::user()->id;
        $this->post->description = $request->description;
        $this->post->image = $this->saveImage($request);
        $this->post->save();

        #save the categories to the category_post_table
        foreach($request->category as $category_id){
            $category_post[] = [
                'category_id' => $category_id
            ];
        }
        $this->post->categoryPost()->createMany($category_post);
        //for $this->post, the post ids are all the same

        #Go back to homepage
        return redirect()->route('index');


    }

    private function saveImage($request)
        {
            #rename the image to the current time to avoid overwriting
            $image_name = time().".".$request->image->extension();

            #save the image inside storate/app/public/images/
            $request->image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

            return $image_name;
    }

    public function show($id){
        $post = $this->post->findOrFail($id);

        return view('users.posts.show')->with('post', $post);
    }

    public function edit($id){
        $post = $this->post->findOrFail($id);

        #if you are not the owner of he post, you cannot proceed
        if($post->user_id !== Auth::user()->id){
            return redirect()->route('index');
        }

        #get all categories to be displayed
        $all_categories = $this->category->get();

        $selected_categories = []; //even if there is no category it works

        foreach($post->categoryPost as $category_post){
            $selected_categories[] = $category_post->category_id;
        }

        return view('users.posts.edit')
            ->with('post', $post)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id){
        $request->validate([
            'category'    => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image'       => 'mimes:jpg,png,jpeg,gif|max:1048'
        ]);

        #update the post
        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        //if there is a new image
        if($request->image){
            $this->deleteImage($post->image);
            #move the image to the local storage
            $post->image = $this->saveImage($request);
        }

        $post->save();

        #delete all records from category_post related to this post
        $post->categorypost()->delete();

        foreach ($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }
        $post->categoryPost()->createmany($category_post); //$post->categoryPost connects the post table to category_post table (inside Post.php)

        return redirect()->route('post.show', $id);
    }

    private function deleteImage($image_name){
        $image_path = self::LOCAL_STORAGE_FOLDER . $image_name;

        if (Storage::disk('local')->exists($image_path)){
            Storage::disk('local')->delete($image_path);
        }
    }

    public function destroy($id){
        $post = $this->post->findOrFail($id);
        $this->deleteImage($post->image);

        // $post->delete(); //$this->post->destroy

        #option1
        $post->forceDelete();
        #option2 $post->delete();

        return redirect()->route('index');
    }


}
