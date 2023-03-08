<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'project_id',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string'
    ];

     public function getStatuslabelAttribute(){
        //  Flash 1,OPharma 2
        if($this->status == "not_started"){
            return "NOT_STARTED";
        }
        if($this->status == "in_progress"){
            return "IN_PROGRESS";
        }
        if($this->status == "ready_for_test"){
            return "READY_FOR_TEST";
        }
        if($this->status == "completed"){
            return "COMPLETED";
        }
    }

    public function setStatuslabelAttribute($value){
        //  Flash 1,OPharma 2
        if($value == "not_started"){
             $this->attributes['status_label']  = "NOT_STARTED";
        }
        if($value == "in_progress"){
             $this->attributes['status_label']  = "IN_PROGRESS";
        }
        if($value == "ready_for_test"){
             $this->attributes['status_label']  = "READY_FOR_TEST";
        }
        if($value == "completed"){
             $this->attributes['status_label']  = "COMPLETED";
        }
    }

}
