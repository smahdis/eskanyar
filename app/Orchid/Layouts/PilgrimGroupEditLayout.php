<?php

namespace App\Orchid\Layouts;

use App\Models\ProvinceCity;
use App\Models\Tag;
use App\Models\User;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PilgrimGroupEditLayout extends Rows
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

            Input::make('group.team_leader_name')
                ->required()
                ->title(__('نام سرگروه'))
                ->placeholder(__('نام سرگروه')),

            Input::make('group.team_leader_lastname')
                ->required()
                ->title(__('نام خانوادگی سرگروه'))
                ->placeholder(__('نام خانوادگی سرگروه')),

            Input::make('group.team_leader_phone')
//                ->type('number')
                ->required()
                ->title(__('شماره تماس سرگروه'))
                ->placeholder(__('شماره تماس سرگروه')),

            Input::make('group.team_leader_national_code')
                ->required()
                ->title(__('کدملی سرگروه'))
                ->placeholder(__('کدملی سرگروه')),

            Input::make('group.team_leader_birthdate')
                ->required()
                ->title(__('تاریخ تولد سرگروه'))
                ->placeholder(__('تاریخ تولد سرگروه')),

//            ProvinceListener::class,

//            Input::make('group.transport_method')
//                ->required()
//                ->title(__('وسیله مسافرت'))
//                ->help(__('وسیله شخصی، قطار، اتوبوس، هواپیما')),


            Input::make('group.staying_duration_day')
                ->required()
                ->title(__('مدت اقامت'))
                ->placeholder(__('مدت اقامت')),

            Select::make('group.transport_method')
                ->options([
                    'other'   => 'سایر',
                    'personal_vehicle'   => 'وسیله شخصی',
                    'bus'   => 'اتوبوس',
                    'train'   => 'قطار',
                    'airplane'   => 'هواپیما',
                ])
                ->title('وسیله مسافرت'),
//                ->help('Allow search bots to index'),
//
//            Input::make('group.companions_count')
//                ->required()
//                ->title(__('تعداد همراهیان'))
//                ->placeholder(__('تعداد همراهیان')),

            Input::make('group.men_count')
                ->required()
                ->title(__('تعداد مردان گروه'))
                ->help(__('تعداد مردان گروه')),

            Input::make('group.women_count')
                ->required()
                ->title(__('تعداد خانم های گروه'))
                ->help(__('تعداد خانم های گروه')),

            Input::make('group.children_count')
                ->required()
                ->title(__('تعداد کودکان زیر ۵ سال'))
                ->help(__('تعداد کودکان زیر ۵ سال')),

//            CheckBox::make('group.women_only_group')
//                ->title('گروه زنانه')
//                ->placeholder('گروه فقط شامل زنان میشود؟'),

            Relation::make('group.tags.')
                ->fromModel(Tag::class, 'title')
                ->multiple()
                ->title(__('انتخاب تگ')),




        ];
    }
}
