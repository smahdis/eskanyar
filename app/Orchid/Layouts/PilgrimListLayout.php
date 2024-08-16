<?php

namespace App\Orchid\Layouts;

use App\Models\Place;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PilgrimListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'groups';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

            TD::make('title', 'عنوان')
                ->render(function (Place $model) {
                    return Link::make($model->title)
                        ->route('platform.place.edit', $model);
                }),

            TD::make('capacity', 'ظرفیت'),
            TD::make('parking_capacity', "ظرفیت پارکینگ"),

//            TD::make('Status')
//                ->alignCenter()
//                ->render(function (Place $model) {
//                    return $model->named_status;
//                }),





            TD::make('created_at', 'ایجاد')
                ->render(fn (Place $model) => $model->created_at->toDateString()),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Place $place) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the event is deleted, all of its resources and data will be permanently deleted.'))
                            ->method('remove', [
                                'id' => $place->id,
                            ]),
                    ])),
        ];
    }
}
