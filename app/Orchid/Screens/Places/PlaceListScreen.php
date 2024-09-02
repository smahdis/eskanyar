<?php

namespace App\Orchid\Screens\Places;

use App\Models\Icebreaker;
use App\Models\Pilgrim;
use App\Models\PilgrimGroup;
use App\Models\Place;
use App\Orchid\Layouts\EventListLayout;
use App\Orchid\Layouts\PlaceListLayout;
use App\Orchid\Layouts\StatsListLayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
//        DB::enableQueryLog();

        $stats = Pilgrim::
            select('places.id','places.title','gender', DB::raw('COUNT(*) as pilgrims'))
            ->join('pilgrim_groups', 'pilgrim_groups.id', '=', 'pilgrims.group_id')
            ->join('places', 'places.id', '=', 'pilgrim_groups.place_id')
            ->groupBy(['places.id', 'gender'])->get();
//        dd(DB::getQueryLog());

//        var_dump(json_encode($stats));
//        die();

//        foreach($places as $place) {
//            foreach($stats as $stat) {
//                if($place->id == $stat->id) {
//                    $place->stats = $stat;
////                    var_dump($place);
//                }
//            }
//        }
//        var_dump(json_encode($places));
//        die();

        return [
            'places' => $places,
            'stats' => $stats
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
            PlaceListLayout::class,
            StatsListLayout::class
        ];
    }
}
