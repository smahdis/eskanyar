<?php

namespace App\Orchid\Screens;

use App\Models\PilgrimGroup;
use App\Models\Place;
use App\Orchid\Layouts\PilgrimGroupListLayout;
use App\Orchid\Layouts\PilgrimListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class PilgrimGroupListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'groups' => PilgrimGroup::with('members')->with('city')->with('province')->latest()->get()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'لیست گروه ها';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('افزودن گروه جدید')
                ->icon('pencil')
                ->route('platform.pilgrim.group.new')
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
            PilgrimGroupListLayout::class
        ];
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove($id)
    {
//        var_dump($pilgrim->first_name);
//        die();

        PilgrimGroup::destroy($id);
        Alert::info('گروه با موفقیت حذف شد');

        return redirect()->route('platform.pilgrim.group.list');
    }
}
