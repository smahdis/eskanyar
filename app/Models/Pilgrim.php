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
        'team_leader_name',
        'team_leader_national_code',
        'birthdate',
        'transport_method',
        'companions_count',
        'women_count',
        'tag',
        'women_only_group',
        'staying_duration_day',
        'status',
    ];


}
