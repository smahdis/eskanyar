<?php

namespace App\Orchid\Layouts;

use App\Models\Event;
use App\Models\Pilgrim;
use App\Models\Place;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StatsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'stats';
    protected $title = 'آمار ورودی و خروجی';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

            TD::make('title', 'عنوان'),
                TD::make('gender', 'جنسیت')->render(function (Pilgrim $model) {
                    $t = $model->gender == 1 ? "آقا" : "خانم";
                    return $t;
                }),
                TD::make('status', "وضعیت")->render(function (Pilgrim $model) {
//                    $t = $model->status == 1 ? '<span class="label label-primary"> ثبت سیستم </span>' : '<span class="label label-secondary">خروج</span>';
//                    return $t;
                    $t = "";
                    if($model->status == 1) {
                        $t = '<span class="label label-primary"> ثبت سیستم </span>';
                    } elseif($model->status == 2) {
                        $t = '<span class="label label-primary">خروج از اسکان</span>';
                    } elseif($model->status == 3) {
                        $t = '<span class="label label-primary"> ورود به اسکان </span>';
                    }
                    return  $t;
                }),
                TD::make('pilgrims', "تعداد"),

        ];
    }
}
