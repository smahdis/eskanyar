<?php

namespace App\Orchid\Screens;

use App\Models\PilgrimGroup;
use App\Models\Place;
use App\Orchid\Layouts\PilgrimGroupListLayout;
use App\Orchid\Layouts\PilgrimListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

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
            'groups' => PilgrimGroup::with('city')->with('province')->latest()->get()
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
                ->route('platform.pilgrim.group.edit')
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
}
