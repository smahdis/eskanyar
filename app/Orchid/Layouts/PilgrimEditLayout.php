<?php

namespace App\Orchid\Layouts;

use App\Models\Tag;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PilgrimEditLayout extends Rows
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


    protected function fields(): iterable
    {
        return [
        Input::make('pilgrim.first_name')
            ->required()
            ->title(__('نام زائر'))
            ->placeholder(__('نام زائر')),

            Input::make('pilgrim.last_name')
                ->required()
                ->title(__('نام خانوادگی زائر'))
                ->placeholder(__('نام خانوادگی زائر')),

            Input::make('pilgrim.national_code')
//                ->type('number')
                ->required()
                ->title(__('کد ملی'))
                ->placeholder(__('کد ملی')),

            Input::make('pilgrim.mobile')
//                ->type('number')
//                ->required()
                ->title(__('شماره تماس'))
                ->placeholder(__('شماره تماس')),

            Input::make('pilgrim.age')
//                ->type('number')
//                ->required()
                ->title(__('سن'))
                ->placeholder(__('سن')),

            Select::make('pilgrim.gender')
                ->options([
                    '1'   => 'آقا',
                    '2' => 'خانم',
                ])
//                ->multiple()
                ->title('جنسیت,'),


            Relation::make('pilgrim.tags.')
                ->fromModel(Tag::class, 'title')
                ->multiple()
                ->title(__('انتخاب تگ')),
        ];
    }
}
