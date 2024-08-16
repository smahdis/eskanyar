<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsMultiSource;

class Place extends Model
{
    use HasFactory, AsMultiSource ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'address',
//        'lat',
//        'lng',
//        'map',
        'capacity',
//        'tags',
        'parking_capacity',
        'shrine_distance',
//        'admins',
    ];


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function admins()
    {
        return $this->belongsToMany(User::class, 'place_admin');
    }


}
