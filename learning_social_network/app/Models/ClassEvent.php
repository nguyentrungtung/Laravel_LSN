<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassEvent extends Model
{
    protected $table = 'classevent';
    protected $fillable = [
        'class_id', 'title', 'thumbnail', 'content', 'documents', 'start_date', 'end_date', 'author','speaker','created_at','updated_at',
    ];
    protected $hidden = [];

    // 1 sự kiện chỉ thuộc về 1 và chỉ 1 lop mà thui.
    public function NtqClass(){
        return $this->belongsTo('App\Models\NtqClass','class_id','id');
    }

    public function listClassEvent()
    {
        return ClassEvent::all();
    }
}
