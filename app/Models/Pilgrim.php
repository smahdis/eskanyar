<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Pilgrim extends Model
{
    use HasFactory, AsSource;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'first_name',
        'last_name',
        'national_code',
        'mobile',
        'birthdate',
        'gender',
        'tag',
        'status',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


}
