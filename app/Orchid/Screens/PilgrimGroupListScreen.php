<?php

namespace App\Orchid\Screens;

use App\Models\PilgrimGroup;
use App\Models\Place;
use App\Orchid\Layouts\ParticipatorFiltersLayout;
use App\Orchid\Layouts\PilgrimGroupFiltersLayout;
use App\Orchid\Layouts\PilgrimGroupListLayout;
use App\Orchid\Layouts\PilgrimListLayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                ->select(
                    'pilgrim_groups.id',
                    'pilgrim_groups.place_id',
                    'pilgrim_groups.place_title',
                    'pilgrim_groups.team_leader_name',
                    'pilgrim_groups.team_leader_lastname',
                    'pilgrim_groups.team_leader_phone',
                    'pilgrim_groups.team_leader_national_code',
                    'pilgrim_groups.team_leader_birthdate',
                    'pilgrim_groups.province_id',
                    'pilgrim_groups.city_id',
                    'pilgrim_groups.transport_method',
                    'pilgrim_groups.companions_count',
                    'pilgrim_groups.men_count',
                    'pilgrim_groups.women_count',
                    'pilgrim_groups.children_count',
                    'pilgrim_groups.women_only_group',
                    'pilgrim_groups.tag',
                    'pilgrim_groups.staying_duration_day',
                    'pilgrim_groups.status',
                )
                ->join('place_user', 'place_user.place_id', '=', 'pilgrim_groups.place_id')
                ->where('place_user.user_id', Auth::user()->id)
                ->with('members')->with('city')->with('province')->latest()->paginate();
        }

//        var_dump(json_encode($grs));
//        die();

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

    public function submitExit($group_id, $status)
    {

//        $group = PilgrimGroup::where('id', $group_id)->first();
        DB::table('pilgrims')->where('group_id', $group_id)->update(array('status' => $status));

//        Alert::info('گروه با موفقیت حذف شد');

        return redirect()->route('platform.pilgrim.list', ['group' => $group_id]);
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
