<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe extends UuidModel
{
    protected $fillable = [
        'name'
    ];

    public function subjects(){
        return $this->hasMany(Subject::class);
    }
    public function clientDetails(){
        return $this->hasMany(ClientDetails::class);
    }
    public function filepdfs(){
        return $this->hasMany(FilePDF::class);
    }
    public function live(){
        return $this->hasOne(FilePDF::class);
    }

    public function videos(){
        return $this->hasMany(Video::class);
    }
    /*public function teacherDetails(){
        return $this->belongsToMany(TeacherDetails::class,'classe_teacher_details');
    }*/
    /**
     * The teachs that belong to the classe.
     */

    /*public function teaches()
    {
        return $this->belongsToMany(Teach::class, 'teach_classe', 'classe_id', 'teach_id');
    }*/
    public function teaches()
    {
        return $this->hasMany(Teach::class);
    }
}
