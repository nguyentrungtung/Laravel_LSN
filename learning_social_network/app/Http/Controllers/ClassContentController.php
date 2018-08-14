<?php

namespace App\Http\Controllers;

use App\Models\ClassContent;

use Illuminate\Http\Request;
use App\Http\Resources\ClassContentResource;
use App\Http\Requests\ClassContentRequest;

class ClassContentController extends Controller
{
    protected $content;

    public function __construct(ClassContent $content)
    {
        //$this->middleware('auth:api', ['except' => ['login']]);
        $this->content = $content;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paggin = 5;
        //$test = \App\Models\ClassContent::find(1)->with(['class_id','author'])->get()->toArray();
       $test = \App\Models\ClassContent::with(['Users','class_id'])->get();// ->paginate($paggin)
       return response()->json($test,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            "class_id" => 1,
            "title" => $request->title,
            "thumbnail" => 'thumbnail.png', //$request->thumbnail
            "content" => $request->contenttext,
            "level" => $request->level,
            "duration" => 0,  // dựa vào start_date và end_date // thời gian kéo dài buổi học
            "documents" => 0, /// $request->documents
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "author" => $request->author, //là số id
            "is_done" => 0, // đã hoàn thành chưa
            "is_approve" => 0, // tán thành đồng ý.
        ];

        try {
            $this->content->createContent($data);
            return response()->json(['message' => 'OK'],200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassContent  $classContent
     * @return \Illuminate\Http\Response
     */
    public function show(ClassContent $id)
    {
        return new ClassContentResource(ClassContent::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassContent  $classContent
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassContent $classContent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassContent  $classContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassContent $classContent)
    {
        $end_date = $request->input('end_date');
        if (($end_date) >= now()) {
            $is_done = 1;
        } else {
            $is_done = 0;
        }
        $data = [
            "class_id" => $request->input('class_id'),
            "title" => $request->input('title'),
            "thumbnail" => $request->input('thumbnail'),
            "content" => $request->input('content'),
            "level" => $request->input('level'),
            "duration" => $request->input('duration'),
            "documents" => $request->input('documents'),
            "start_date" => $request->input('start_date'),
            "end_date" => $request->input('end_date'),
            "author" => $request->input('author'),
            "is_done" => $is_done,
            "is_approve" => $request->input('is_approve'),
        ];
        $this->content->createContent($data);
        return response()->json(['message' => 'Create OK'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassContent  $classContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassContent $id)
    {
        try {
            $data = new ClassContentResource(ClassContent::destroy($id));
            return response()->json(['message' => 'OK'],200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}
