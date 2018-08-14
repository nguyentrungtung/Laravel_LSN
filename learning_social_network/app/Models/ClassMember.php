<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMember extends Model
{
    protected $table = 'classmember';
    protected $fillable = [
        'class_id', 'user_id', 'is_captain', 'is_mentor', 'statust','created_at','updated_at',
    ];
    protected $hidden = [];

    public function listClassMember()
    {
        $list = ClassMember::All();
        return $list;
    }
    public function createMember(array $data){
        ClassMember::create($data);
    }
    // 1 member chỉ thuộc về 1 user mà thôi Users
    public function user_id(){
        return $this->belongsTo('App\Models\User','user_id','id'); //App\Models\Users
    }

    // 1 member chỉ thuộc về 1 user mà thôi Users
    public function Users(){
        return $this->belongsTo('App\Models\User','user_id','id'); //App\Models\Users
    }

    // 1 member chỉ thuộc về 1 lớp NtqClass
    public function class_id(){
        return $this->belongsTo('App\Models\NtqClass','class_id','id');
    }

    public function deleteMember($id){
        ClassMember::delete($id);
    }


}
