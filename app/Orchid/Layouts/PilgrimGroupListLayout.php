<?php

namespace App\Orchid\Layouts;

use App\Models\PilgrimGroup;
use App\Models\Place;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PilgrimGroupListLayout extends Table
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

            TD::make('team_leader_name', 'سرگروه')
                ->render(function (PilgrimGroup $model) {
                    return $model->team_leader_name . ' ' . $model->team_leader_lastname;
                }),

//            TD::make('team_leader_national_code', 'کد ملی'),
            TD::make('team_leader_phone', 'شماره تماس'),
            TD::make('province.title', 'استان'),
            TD::make('city.title', 'شهر'),
            TD::make('transport_method', "وسیله")->render(function (PilgrimGroup $model) {
                $pg = new PilgrimGroup();
                return $pg->transport_methods[$model->transport_method];
            }),
//            TD::make('companions_count', "تعداد همراهیان"),
            TD::make('men_count', "آقایان"),
            TD::make('women_count', "خانمها"),
            TD::make('children_count', "کودکان"),
            TD::make('women_only_group', "گروه زنانه"),
            TD::make('staying_duration_day', "اقامت")->render(function (PilgrimGroup $model) {
                return $model->staying_duration_day . ' روز ';
            }),

//            TD::make('Status')
//                ->alignCenter()
//                ->render(function (Place $model) {
//                    return $model->named_status;
//                }),
            TD::make('companions', 'ویرایش')
                ->render(fn (PilgrimGroup $model) =>
                    Link::make(__('Edit'))
                        ->route('platform.pilgrim.group.edit', $model->id)
                        ->icon('bs.pencil')),

            TD::make('created_at', 'ایجاد')
                ->render(fn (PilgrimGroup $model) => verta($model->created_at->toDateString())->format('Y-m-d')),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (PilgrimGroup $model) => DropDown::make()
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
