<?php

namespace App\Orchid\Screens;

use App\Models\Pilgrim;
use App\Models\Sms;
use App\Orchid\Layouts\PilgrimListLayout;
use App\Orchid\Layouts\SmsListLayout;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class SmsListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
//        $group_id = Route::getCurrentRoute()->group;

        return [
            'sms' => Sms::latest()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'پیامک';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $group_id = Route::getCurrentRoute()->group;
        return [
            Link::make('ارسال پیامک جدید')
                ->icon('pencil')
                ->route('platform.sms.new')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SmsListLayout::class
        ];
    }

    /**
     * @param Pilgrim $pilgrim
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove($id)
    {
//        var_dump($pilgrim->first_name);
//        die();

        Sms::destroy($id);
//        $group_id = Route::getCurrentRoute()->group;
        Alert::info('پیامک با موفقیت حذف شد');

        return redirect()->route('platform.sms.list');
    }
}
