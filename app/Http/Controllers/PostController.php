<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    public function store(Request $request)
    {
        // Validate the request data, including file validation for the image
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',// Adjust the allowed image types and size as needed
            'image'=>'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Return validation errors
        }
    
        // Store the uploaded image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName); // Store the image in the public/images directory
        }

        // Create and store the blog post
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->image = $imageName; // Store the image filename in the database
        $post->user_id = Auth::user()->id;
        $post->category_id = $request->input('category_id'); 
        $post->save();
    
        return response()->json(['message' => 'Post created successfully'], 201); // Return a success response
    }
    public function sendCategories(){
        $category=Category::all();
        return response()->json([
            'category'=>$category
        ], 201);
    }
    public function posts(){
        $posts = Post::with('user','likes')->latest()->get();
  
        return response()->json([
            'posts'=>$posts,
       
        ]);
    }
    public function myPosts(){
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->latest()->get();
        return response()->json([
            'posts'=>$posts,
        ]);
    }
    public function likePost(Request $request, $postId)
    {
        $user = Auth::user();

        // Find the post by its ID
        $post = Post::find($postId);

        // Check if the post exists
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        // Check if the user has already liked the post
        $existingLike = Like::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            return response()->json([
                'message' => 'You have already liked this post',
                "liked_by_user"=> true,
            ]);
        }

        // Create a new like record
        $like = new Like();
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        $like->save();

        // Increment the likes_count in the posts table
        $post->increment('likes_count');

        return response()->json(['message' => 'Post liked successfully']);
    }
        // Retrieve comments for a post
        public function comments($post)
        {
            $comments = Comment::where('post_id', $post)->get();
    
            return response()->json(['comments' => $comments]);
        }
        public function storeComments(Request $request)
        {
            $request->validate([
                'post_id' => 'required|exists:posts,id',
                'content' => 'required',
            ]);
    
            $comment = Comment::create([
                'user_id' => auth()->user()->id,
                'post_id' => $request->post_id,
                'content' => $request->content,
            ]);
    
            return response()->json(['message' => 'Comment created successfully', 'comment' => $comment]);
        }
}
