<?php

namespace App\Orchid\Screens;

use App\Models\Pilgrim;
use App\Models\PilgrimGroup;
use App\Orchid\Layouts\PilgrimListLayout;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PilgrimListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $group_id = Route::getCurrentRoute()->group;

        return [
            'pilgrims' => Pilgrim::where('group_id', $group_id)->latest()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'اعضای گروه';
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
            Link::make('افزودن عضو جدید')
                ->icon('pencil')
                ->route('platform.pilgrim.new', ["group" => $group_id])
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
            PilgrimListLayout::class
        ];
    }
}
