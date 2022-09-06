<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreBlogRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
        $image_path = "No Image";
//        if ($request->hasFile('image')) {
//            $image = $request->hasFile('image');
//            $prefix = time();
//            $size = 300;
//            $width = 400;
//
//            $image_name = $prefix . '-' . $width . 'x' . $size . '-' . $image->getClientOriginalName();
//
//            $image_path = "uploads/blogs/$image_name";
//
//            $resized_image = Image::make($image)->resize($size['width'], $size['height'])->stream();
//
//            Storage::put($image_path, $resized_image);
//        }

        $data = Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'status' => $request->status,
            'image' => $image_path,
            'created_by' => $request->created_by,
            'description' => $request->description
        ]);

        DB::commit();

        return response()->json([
            'status' => 201,
            'message' => 'Blog Created Successfully',
            'data' => $data,
        ]);

        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $exception->getMessage(),
                'data' => [],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Admin\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Admin\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateBlogRequest $request
     * @param \App\Models\Admin\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $blog = Blog::findOrFail($id);
        try {


//        if ($request->hasFile('image')) {
//            $image = $request->hasFile('image');
//            $prefix = time();
//            $size = 300;
//            $width = 400;
//
//            $image_name = $prefix . '-' . $width . 'x' . $size . '-' . $image->getClientOriginalName();
//
//            $image_path = "uploads/blogs/$image_name";
//
//            $resized_image = Image::make($image)->resize($size['width'], $size['height'])->stream();
//
//            Storage::put($image_path, $resized_image);
//        }
            $image_path = 'fg';
            $blog->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'status' => $request->status,
                'image' => $image_path,
                'created_by' => $request->created_by,
                'description' => $request->description
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Blog Updated Successfully',
                'data' => $blog,
            ]);

        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $exception->getMessage(),
                'data' => [],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Admin\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        DB::beginTransaction();

        try {
            if (Storage::exists($blog->image)) {
                Storage::delete($blog->image);
            }
            $blog->delete();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Blog Deleted Successfully',
                'data' => [],
            ]);
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => $exception->getMessage(),
                'data' => [],
            ]);
        }
    }
}
