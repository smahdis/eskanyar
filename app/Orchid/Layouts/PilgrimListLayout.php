<?php

namespace App\Orchid\Layouts;

use App\Models\Pilgrim;
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
    protected $target = 'pilgrims';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

//            TD::make('title', 'عنوان')
//                ->render(function (Place $model) {
//                    return Link::make($model->title)
//                        ->route('platform.place.edit', $model);
//                }),

            TD::make('first_name', 'نام'),
            TD::make('last_name', 'نام خانوادگی'),
            TD::make('national_code', 'کد ملی'),
            TD::make('mobile', 'شماره همراه'),
            TD::make('birthdate', 'تولد'),
            TD::make('gender', 'جنسیت'),

//            TD::make('Status')
//                ->alignCenter()
//                ->render(function (Place $model) {
//                    return $model->named_status;
//                }),





            TD::make('created_at', 'ایجاد')
                ->render(fn (Pilgrim $model) => $model->created_at->toDateString()),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Pilgrim $model) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the event is deleted, all of its resources and data will be permanently deleted.'))
                            ->method('remove', [
                                'id' => $model->id,
                            ]),
                    ])),
        ];
    }
}
