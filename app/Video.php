<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    protected $table = 'videos';

    //Relacion de uno a muchos ejem: en un video hay muchos comentarios
    public function comments(){
    	return $this->hasMany('App\Comment')->orderBy('id','desc');
    	//Relacion de uno a uno hasOne
    }

    //Relacion de muchos a uno
    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }
}