<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ClassMemberResource;
use App\Models\ClassMember;

class ClassMemberController extends Controller
{
    protected $member;

    public function __construct(ClassMember $member)
    {
        //$this->middleware('auth:api', ['except' => ['login']]);
        $this->member = $member;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paggin = 5;
        //$data = \App\Models\ClassMember::find(1)->with(['user_id'])->paginate($paggin);
        $data = \App\Models\ClassMember::find(1)->with(['Users'])->get()->toArray();
        return response()->json($data,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //imail kem id
        $data = [
            "class_id" => 1,
            "user_id" => $request->user_id,
            "is_captain" => 0,
            "is_mentor" => 0,
            "statust" => 0,
        ];

        try {
            $this->member->createMember($data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassContent  $classContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassMember $member ,Request $request)
    {
        $data = [
            "id" => $request->id,
            "is_captain" => $request->is_captain,
           //"is_mentor" => $request->is_mentor,
        ];

//        echo $data['is_captain'].'<br>';
//        echo $data['id']; die();
        if ($data['is_captain'] == 1) {
            //echo 'dang vao captian dc quyen xoa';
            try {
                $this->member->deleteMember($data['id']);
                return response()->json(['message' => 'OK'], 200);
            } catch (Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        } else{
            return response()->json(['message' => 'ko dc quyen xoa'], 200);
        }

    }
}
