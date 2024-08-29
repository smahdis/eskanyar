<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class PilgrimGroup extends Model
{
    use HasFactory, AsSource;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_leader_name',
        'team_leader_lastname',
        'team_leader_phone',
        'team_leader_national_code',
        'team_leader_birthdate',
        'province_id',
        'city_id',
        'transport_method',
        'companions_count',
        'men_count',
        'women_count',
        'children_count',
        'women_only_group',
        'tag',
        'staying_duration_day',
        'status',
    ];

    public $transport_methods = [
        'other' => 'سایر',
        'personal_vehicle' => 'وسیله شخصی',
        'bus' => 'اتوبوس',
        'train' => 'قطار',
        'airplane' => 'هواپیما',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function members()
    {
        return $this->hasMany(Pilgrim::class, 'group_id');
    }

    public function city()
    {
        return $this->belongsTo(ProvinceCity::class);
    }

    public function province()
    {
        return $this->belongsTo(ProvinceCity::class);
    }

}
