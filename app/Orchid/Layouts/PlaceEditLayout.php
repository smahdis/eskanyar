<?php

namespace App\Orchid\Layouts;

use App\Models\Menu;
use App\Models\Tag;
use App\Models\User;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PlaceEditLayout extends Rows
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = '';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): iterable
    {
        return [

            Input::make('place.title')
                ->required()
                ->title(__('عنوان'))
                ->placeholder(__('عنوان مکان'))
                ->help(__('عنوان مکان')),


            TextArea::make('place.description')
                ->rows(3)
                ->maxlength(255)
                ->title(__('توضیحات'))
                ->placeholder(__('توضیح مختصر از مکان')),

            Input::make('place.address')
                ->required()
                ->title(__('آدرس مکان'))
                ->placeholder(__('آدرس مکان')),
//                ->help(__('This will be shown in place detail page')),

            Relation::make('place.tags.')
                ->fromModel(Tag::class, 'title')
                ->multiple()
                ->title(__('انتخاب تگ')),

            Map::make('place.map')
                ->title('لطفا موقعیت دقیق مکان رو در نقشه انتخاب کنید')
                ->help('میتوانید به جای انتخاب از روی نقشه، موقعیت جغرافیایی را وارد کنید'),

            Input::make('place.capacity')
                ->required()
                ->title(__('ظرفیت'))
                ->placeholder(__('ظرفیت')),
//                ->help(__('This will be shown in place detail page')),

            Input::make('place.parking_capacity')
                ->required()
                ->title(__('ظرفیت پارکینگ'))
                ->placeholder(__('ظرفیت پارکینگ')),
//                ->help(__('This will be shown in place detail page')),


            Input::make('place.shrine_distance')
                ->required()
                ->title(__('فاصله تا حرم'))
                ->placeholder(__('فاصله تا حرم')),
//                ->help(__('This will be shown in place detail page')),

            Relation::make('place.admins.')
                ->fromModel(User::class, 'name')
                ->multiple()
                ->title(__('مدیر مکان')),

        ];
    }
}
