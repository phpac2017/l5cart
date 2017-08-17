<?php

namespace App\Http\Controllers;
use App\Post;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function blog() {
	    $posts = Post::where('id', '>', 0)->paginate(3);
	    //dd($posts);
	    $posts->setPath('blog');

	    $data['posts'] = $posts;

	    return view('blog', array('data' => $data, 'title' => 'Latest Blog Posts', 'description' => '', 'page' => 'blog', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
	}

	public function blog_post($url) {
	    $post = Post::whereUrl($url)->first();

	    $tags = $post->tags;
	    $prev_url = Post::prevBlogPostUrl($post->id);
	    $next_url = Post::nextBlogPostUrl($post->id);
	    $title = $post->title;
	    $description = $post->description;
	    $page = 'blog';
	    $brands = $this->brands;
	    $categories = $this->categories;
	    $products = $this->products;

	    $data = compact('prev_url', 'next_url', 'tags', 'post', 'title', 'description', 'page', 'brands', 'categories', 'products');

	    return view('blog_post', $data);
	}
}
