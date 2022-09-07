<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return response()->json(['status' => 200, 'message' => '', 'data' => $blogs]);
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

        $data = Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'status' => $request->status === true ? "true" : "false" ,
            'created_by' => Auth::id(),
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
    public function retrieve($id)
    {
        $blog = Blog::findOrFail($id);

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $blog,
        ]);
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
            $blog->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'status' => $request->status,
                'created_by' => Auth::id(),
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
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $blog = Blog::findOrFail($id);

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
