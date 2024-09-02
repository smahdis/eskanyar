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
                TD::make('pilgrims', "تعداد"),

        ];
    }
}
