<?php

namespace App\Orchid\Screens\Places;

use App\Models\Icebreaker;
use App\Models\PilgrimGroup;
use App\Models\Place;
use App\Orchid\Layouts\EventListLayout;
use App\Orchid\Layouts\PlaceListLayout;
use Illuminate\Support\Facades\Auth;
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
        $super_admin = Auth::user()->hasAccess('super_admin');

        if($super_admin) {
            $places = Place::latest()->get();
        } else {
            $places = Place::
            join('place_user', 'place_user.place_id', '=', 'places.id')
                ->where('place_user.user_id', Auth::user()->id)
                ->latest()->get();
        }

        return [
            'places' => $places
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
                ->route('platform.place.new')
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
