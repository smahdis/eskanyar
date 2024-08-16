<?php

namespace App\Orchid\Screens\Places;

use App\Models\Icebreaker;
use App\Models\Place;
use App\Orchid\Layouts\EventListLayout;
use App\Orchid\Layouts\PlaceListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PlaceListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'places' => Place::latest()->get()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'مکان ها';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('افزودن مکان جدید')
                ->icon('pencil')
                ->route('platform.place.edit')
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
            PlaceListLayout::class
        ];
    }
}
