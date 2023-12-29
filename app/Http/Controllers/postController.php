<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\postImage;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\StrongRenderer;
use PhpParser\JsonDecoder;

class postController extends Controller
{

    public function getallPosts($profileid)
    {
        // $profile=Profile::find($profileid);
        $message = [];
        $images = [];


        $posts = Post::where('profileid', '!=', $profileid)->orderBy('created_at', 'desc')->get();
       
        for ($i = 0; $i < count($posts); $i++) {
            $postimages = postImage::where('postid', $posts[$i]->id)->get();
            array_push($images, $postimages);
        }

        for ($i = 0; $i < count($posts); $i++) {
            array_push(
                $message,

                [
                    'postdata' => $posts[$i],
                    'subcategorydata' => $posts[$i]->subcategory,
                    'postimagedata' => $images[$i],
                    'profiledata' => $posts[$i]->profile,
                    'userdata' => $posts[$i]->profile->user
                ]
            );
        }

        if (count($posts) > 0) {
           
                          return json_encode([
                'status' => 'success',
                'message' => $message
            ]);
        }
        return json_encode([
            'status' => 'failed',
        ]);
    }

    public function getPosts($profileid)
    {
        $message = [];
        $images = [];


        $posts = Post::where('profileid', $profileid)->orderBy('created_at', 'desc')->get();

        for ($i = 0; $i < count($posts); $i++) {
            $postimages = postImage::where('postid', $posts[$i]->id)->get();
            array_push($images, $postimages);
        }

        for ($i = 0; $i < count($posts); $i++) {
            array_push(
                $message,

                [
                    'postdata' => $posts[$i],
                    'subcategorydata' => $posts[$i]->subcategory,
                    'servicetype' =>
                    $posts[$i]->subcategory->maincategory->servicetype,
                    'postimagedata' => $images[$i]
                ]
            );
        }

        if (count($posts) > 0) {
            return json_encode([
                'status' => 'success',
                'message' => $message
            ]);
        }
        return json_encode([
            'status' => 'failed',
        ]);
    }
    public function addPost(Request $request)
    {
        $post = new Post();
        $validatepost = Validator::make(
            $request->all(),
            [
                'title' => 'min:50|max:100',
                'content' => 'min:100|max:1000'
            ]
        );
        if ($validatepost->fails()) {
            return json_encode([
                'status' => 'failed',
                'message' => $validatepost->errors()
            ]);
        }
        if ($request->files) {
            $imageres = 0;
            $postres = 0;
            $post->title = $request->title;
            $post->content = $request->content;
            $post->date = $request->date;
            $post->lat = $request->lat;
            $post->long = $request->long;
            $post->status = $request->status;
            $post->price = $request->price;
            $post->subcategoryid = $request->subcategoryid;
            $post->profileid = $request->profileid;
            $postres = $post->save();

            $postid =  DB::getPdo()->lastInsertId();

            for ($i = 1; $i <= count($request->files); $i++) {
                $file =  $request->file('file' . $i)->store('public');
                $postimage = new postImage();
                $postimage->imageurl = basename($file);
                $postimage->postid = $postid;
                $imageres =  $postimage->save();
            }
            if ($imageres && $postres) {
                return json_encode([
                    'status' => 'success',
                ]);
            }
        } else {
            return json_encode([
                'message' => 'Post must has at least one image',
                'status' => 'failed',
            ]);
        }



        return json_encode([
            'status' => 'failed',
        ]);
    }
    public function updatePost(Request $request)
    {

        $post = Post::find($request->id);
        // return $post;
        if ($post) {

            $validatepost = Validator::make(
                $request->all(),
                [
                    'title' => 'min:20|max:100',
                    'content' => 'min:100|max:1000'
                ]
            );
            if ($validatepost->fails()) {
                return json_encode([
                    'status' => 'failed',
                    'message' => $validatepost->errors()
                ]);
            }
        }
        // if ($request->has('title')) {

        $post->title = $request->title;
        $post->content = $request->content;
        $post->date = $request->date;
        $post->status = $request->status;
        $post->price = $request->price;
        $post->lat = $request->lat;
        $post->long = $request->long;

        $post->subcategoryid = $request->subcategoryid;
        $post->profileid = $request->profileid;
        $post = $post->save();
        // }

        if ($request->files) {
            for ($i = 0; $i < count($request->files); $i++) {
                $postimage = postImage::find($request->imageid[$i]);
                // return $postimage;
                Storage::delete('public/' . $postimage->imageurl);
                $file =  $request->file('file' . $i + 1)->store('public');
                $postimage->imageurl = basename($file);
                $postimage = $postimage->save();
            }
        }
        if ($post || $postimage) {
            return json_encode([
                'status' => 'success',
            ]);
        }


        return json_encode([
            'status' => 'failed',
        ]);
    }
    public function deletePost(Request $request)
    {
        $post = Post::find($request->id);

        if ($post) {
            $images = postImage::where('postid', $request->id)->get();
            for ($i = 0; $i < count($images); $i++) {
                Storage::delete('public/' . $images[$i]);
            }
            $post = $post->delete();
            return json_encode([
                'status' => 'success',
            ]);
        }
        return  json_encode([
            'status' => 'failed',
        ]);
    }
}
