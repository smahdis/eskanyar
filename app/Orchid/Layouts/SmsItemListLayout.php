<?php

namespace App\Orchid\Layouts;

use App\Models\Sms;
use App\Models\SmsItem;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SmsItemListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'items';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

            TD::make('phone', 'شماره'),
            TD::make('result', 'وضعیت پیام'),

            TD::make('created_at', 'ایجاد')
                ->render(fn (SmsItem $model) => $model->created_at->toDateString()),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (SmsItem $model) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
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
