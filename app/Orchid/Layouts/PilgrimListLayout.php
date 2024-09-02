<?php

namespace App\Orchid\Layouts;

use App\Models\Pilgrim;
use App\Models\PilgrimGroup;
use App\Models\Place;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;
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

            TD::make('first_name', 'نام')
                ->render(fn (Pilgrim $model) =>
                Link::make($model->first_name . ' ' . $model->last_name)
                    ->route('platform.pilgrim.edit', $model->id)
    //                    ->icon('bs.pencil')
                ),
            TD::make('national_code', 'کد ملی'),
            TD::make('mobile', 'شماره همراه'),
            TD::make('status', 'وضعیت')->render(function (Pilgrim $model) {
//                $t = $model->status == 1 ? '<span class="label label-primary"> ثبت سیستم </span>' : '<span class="label label-secondary">خروج</span>';
                $t = "";
                if($model->status == 1) {
                    $t = '<span class="label label-primary"> ثبت سیستم </span>';
                } elseif($model->status == 2) {
                    $t = '<span class="label label-primary">خروج</span>';
                } elseif($model->status == 3) {
                    $t = '<span class="label label-success"> ورود به اسکان </span>';
                }
                return  $t;
            }),
            TD::make('gender', 'جنسیت')
                ->render(function (Pilgrim $model) {
                    return $model->gender == 1 ? 'مرد' : 'زن';
            }),



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
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Button::make(__('ثبت خروج'))
                            ->icon('bs.box-arrow-right')
//                            ->confirm(__('Once the event is deleted, all of its resources and data will be permanently deleted.'))
                            ->method('submitExit', [
                                'id' => $model->id,
                                'status' => 2
                            ]),
                        Button::make(__('ثبت ورود'))
                            ->icon('bs.box-arrow-right')
//                            ->confirm(__('Once the event is deleted, all of its resources and data will be permanently deleted.'))
                            ->method('submitExit', [
                                'id' => $model->id,
                                'status' => 3
                            ]),
                        Button::make(__('تبدیل وضعیت به ثبت سیستم'))
                            ->icon('bs.box-arrow-right')
//                            ->confirm(__('Once the event is deleted, all of its resources and data will be permanently deleted.'))
                            ->method('submitExit', [
                                'id' => $model->id,
                                'status' => 1
                            ]),
                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('آیا مطمئن به حذف هستید؟ این عملیات غیر قابل بازگشت است'))
                            ->method('remove', [
                                'id' => $model->id,
                            ]),
                    ])),
        ];
    }
}
