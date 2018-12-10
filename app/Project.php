<?php

namespace App;

use App\Mail\ProjectCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //protected $fillable = ['title', 'description']; //Usar para protección, que solo esos campos puedes ser modiicados
    protected $guarded = []; //Usar cuando se está seguro que ningun otro campo puede ser modificado

    protected static function boot(){
        parent::boot();

        static::created(function ($project){
            \Mail::to($project->owner->email)->send(
                new ProjectCreated($project)
            );
        });
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function addTask($task){

        $this->tasks()->create($task);

    }
}
