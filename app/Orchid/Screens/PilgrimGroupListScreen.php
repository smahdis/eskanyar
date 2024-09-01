<?php

namespace App\Orchid\Screens;

use App\Models\PilgrimGroup;
use App\Models\Place;
use App\Orchid\Layouts\ParticipatorFiltersLayout;
use App\Orchid\Layouts\PilgrimGroupFiltersLayout;
use App\Orchid\Layouts\PilgrimGroupListLayout;
use App\Orchid\Layouts\PilgrimListLayout;
use Illuminate\Support\Facades\Auth;
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
        $super_admin = Auth::user()->hasAccess('super_admin');

//        var_dump($super_admin);
//        die();

        if($super_admin) {
            $grs = PilgrimGroup::filters(PilgrimGroupFiltersLayout::class)->with('members')->with('city')->with('province')->latest()->paginate();
        } else {

            $grs = PilgrimGroup::filters(PilgrimGroupFiltersLayout::class)
                ->join('place_user', 'place_user.place_id', '=', 'pilgrim_groups.place_id')
                ->where('place_user.user_id', Auth::user()->id)
                ->with('members')->with('city')->with('province')->latest()->paginate();
        }

        return [
            'groups' => $grs
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
            PilgrimGroupFiltersLayout::class,
            PilgrimGroupListLayout::class
        ];
    }


    public function assign($group_id, $place_id)
    {

        $group = PilgrimGroup::where('id', $group_id)->first();
        $place = Place::where('id', $place_id)->first();
        $group->place_id = $place_id;
        $group->place_title = $place->title;
        $group->save();
//        Alert::info('گروه با موفقیت حذف شد');

        return redirect()->back();
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
