<?php

namespace App\Orchid\Layouts;

use App\Models\Tag;
use App\Models\User;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SmsEditLayout extends Rows
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

            Input::make('sms.title')
                ->required()
                ->title(__('عنوان'))
                ->placeholder(__('عنوان پیامک'))
                ->help(__('عنوان پیامک مثلا: گروه زائر اولی ها')),

            Select::make('sms.template')
                ->options([
                    'khadem'   => 'خادم',
                ])
//                ->multiple()
                ->title('الگو,'),

            TextArea::make('sms.contacts')
                ->rows(10)
//                ->maxlength(255)
                ->title(__('مخاطبین'))
                ->placeholder(__('هر شماره در یک خط جدید')),

            Input::make('sms.token1')
                ->required()
                ->title(__('توکن 1')),

            Input::make('sms.token2')
                ->required()
                ->title(__('توکن 2')),

            Input::make('sms.token3')
                ->required()
                ->title(__('توکن 3')),

        ];
    }
}
