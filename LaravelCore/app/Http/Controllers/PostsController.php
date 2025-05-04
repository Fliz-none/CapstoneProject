<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function post(Request $request)
    {

        if ($request->sub) {
            $products = Product::where('status', '>', 0)->orderBy('sort', 'ASC')->paginate(12);
            $posts = Post::where('status', '>', 0)->orderBy('created_at', 'DESC')->paginate(4);
            if ($request->category) {
                $category = Category::whereStatus(1)->with('posts')->whereSlug($request->category)->first();
                if ($category) {
                    $posts = Post::where('category_id', $category->id)->whereStatus(1)->orderBy('created_at', 'DESC')->paginate(4);

                    if ($request->post) {
                        $post = Post::where('status', '>', 0)->where('category_id', $category->id)->whereSlug($request->post)->first();
                        if ($post) {
                            $pageName = $post->title;
                            $relatedPosts = $category->posts->filter(function ($relatedPost) use ($post) {
                                return $relatedPost->id !== $post->id;
                            });
                            return view('web.post', compact('pageName', 'post', 'relatedPosts'));
                        } else {
                            abort(404);
                        }
                    } else {
                        $pageName = $category->name;
                        return view('web.posts', compact('pageName', 'category', 'posts'));
                    }
                } else {
                    abort(404);
                }
            }
            switch ($request->sub) {
                case 'benh-vien-thu-y':
                    $pageName = 'Bệnh viện thú y';
                    return view('web.posts.benh-vien-thu-y', compact('pageName', 'products'));
                case 'spa-&-grooming':
                    $pageName = 'Spa & Grooming';
                    return view('web.posts.spa-&-grooming', compact('pageName', 'products'));
                case 'khach-san-thu-cung':
                    $pageName = 'Khách sạn thú cưng';
                    return view('web.posts.khach-san-thu-cung', compact('pageName', 'products'));
                case 've-truongdung-pet':
                    $pageName = 'Về TRUONGDUNG PET';
                    return view('web.posts.ve-truongdung-pet', compact('pageName', 'products'));
                case 'posts':
                    $pageName = 'Các bài viết từ TruongDungPet';
                    return view('web.posts', compact('pageName', 'posts'));
                default:
                    abort(404, 'Category not found');
            }
        }
        // else {
        //     $pageName = 'Các bài viết';
        //     return view('web.posts', compact('pageName'));
        // }
    }
}