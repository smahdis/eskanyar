<?php

namespace App\Orchid\Screens;

use App\Models\Group;
use App\Models\Pilgrim;
use App\Models\PilgrimGroup;
use App\Orchid\Layouts\PilgrimGroupEditLayout;
use App\Orchid\Layouts\Product\ProductEditLayout;
use App\Orchid\Layouts\ProvinceListener;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PilgrimGroupEditScreen extends Screen
{
    /**
     * @var PilgrimGroup
     */
    public $group;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(PilgrimGroup $group): iterable
    {
//        $group->load('attachment');
        return [
            'group' => $group,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->group->exists ? 'ویرایش گروه' : 'افزودن گروه جدید';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('ایجاد گروه')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->group->exists),

            Button::make('ویرایش')
                ->icon('note')
                ->method('update')
                ->canSee($this->group->exists),

            Button::make('جذف')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->group->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
//        var_dump($this->group);
//        die();

        return [
            Layout::block([
                PilgrimGroupEditLayout::class
            ])
                ->title(__('گروه'))
                ->description('لطفا تمام اطلاعات رو تکمیل کنید'),

            Layout::block([
                ProvinceListener::class,
            ])
                ->title(__('استان و شهر'))
                ->description(__('شهر و استان محل سکونت زائر'))

//            Layout::block([
//                BranchEditLayout::class,
//            ])
//                ->title(__('Other Branch Info'))
//                ->description('These section is common between all languages and does not require translation.')

        ];
    }

    function convert2english($string) {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string =  str_replace($persianDecimal, $newNumbers, $string);
        $string =  str_replace($arabicDecimal, $newNumbers, $string);
        $string =  str_replace($arabic, $newNumbers, $string);
        return str_replace($persian, $newNumbers, $string);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {

//        var_dump($data);
//        die();

        $this->validate(request(), [
            'group.team_leader_name' => 'required|max:255',
            'group.team_leader_lastname' => 'required|max:2048',
            'group.team_leader_phone' => 'required|max:512',
            'group.team_leader_national_code' => 'required',
//            'group.team_leader_birthdate' => 'required|max:255',
//            'group.transport_method' => 'required|max:255',
//            'group.companions_count' => 'required|max:255',
//            'group.men_count' => 'required|max:255',
//            'group.women_count' => 'required|max:255',
//            'group.children_count' => 'required|max:255',
//            'group.women_only_group' => 'required|max:255',
//            'group.staying_duration_day' => 'required|max:255',
//            'group.admins' => 'required|max:255',
//            'group.map.lat' => 'required|max:255',
//            'group.map.lng' => 'required|max:255',

        ], [],
            [
                'group.team_leader_name' => 'نام سرگروه',
                'group.team_leader_lastname'=> 'نام خانوادگی سرگروه',
                'group.team_leader_phone'=> 'تلفن تماس سرگروه',
                'group.team_leader_national_code' => 'کد ملی سرگروه',
//                'group.team_leader_birthdate' => 'تاریخ تولد سرگروه',
//                'group.transport_method' => 'وسیله مسافرت',
//                'group.companions_count' => 'تعداد همراهان',
//                'group.men_count' => 'تعداد مردان',
//                'group.women_count' => 'تعداد خانم ها',
//                'group.children_count' => 'تعداد کودکان',
//                'group.women_only_group' => 'گروه زنانه',
//                'group.staying_duration_day' => 'مدت اقامت',
//                'group.admins' => 'admin',
//                'group.map.lat'=> 'Latitude',
//                'group.map.lng'=> 'Longitude',
            ]);

        $data = $request->get('group');

        $data['team_leader_phone'] = $this->convert2english($data['team_leader_phone']);
        $data['team_leader_national_code'] = $this->convert2english($data['team_leader_national_code']);
//        $data['team_leader_birthdate'] = $this->convert2english($data['team_leader_birthdate']);
//        $data['men_count'] = $this->convert2english($data['men_count']);
//        $data['women_count'] = $this->convert2english($data['women_count']);
//        $data['children_count'] = $this->convert2english($data['children_count']);
//        $data['staying_duration_day'] = $this->convert2english($data['staying_duration_day']);

        $tags = $data['tags'] ?? [];


        if(empty($data['men_count']) || $data['men_count']==0) {
            $tags[] = "4";
        }

        if(empty($this->group)) {
            $this->group = new PilgrimGroup();
        }
        $this->group->fill($data)->save();
        $this->group->tags()->sync($tags);


//        $group->admins()->sync($tags);

        Alert::info('گروه با موفقیت ایجاد شد');

        return redirect()->route('platform.pilgrim.group.list');
    }


    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request, PilgrimGroup $group): RedirectResponse
    {

//        var_dump($data);
//        die();

        $this->validate(request(), [
            'group.team_leader_name' => 'required|max:255',
            'group.team_leader_lastname' => 'required|max:2048',
            'group.team_leader_phone' => 'required|max:512',
            'group.team_leader_national_code' => 'required',
//            'group.team_leader_birthdate' => 'required|max:255',
//            'group.transport_method' => 'required|max:255',
//            'group.companions_count' => 'required|max:255',
//            'group.men_count' => 'required|max:255',
//            'group.women_count' => 'required|max:255',
//            'group.children_count' => 'required|max:255',
//            'group.women_only_group' => 'required|max:255',
//            'group.staying_duration_day' => 'required|max:255',
//            'group.admins' => 'required|max:255',
//            'group.map.lat' => 'required|max:255',
//            'group.map.lng' => 'required|max:255',

        ], [],
            [
                'group.team_leader_name' => 'نام سرگروه',
                'group.team_leader_lastname'=> 'نام خانوادگی سرگروه',
                'group.team_leader_phone'=> 'تلفن تماس سرگروه',
                'group.team_leader_national_code' => 'کد ملی سرگروه',
//                'group.team_leader_birthdate' => 'تاریخ تولد سرگروه',
//                'group.transport_method' => 'وسیله مسافرت',
//                'group.companions_count' => 'تعداد همراهان',
//                'group.men_count' => 'تعداد مردان',
//                'group.women_count' => 'تعداد خانم ها',
//                'group.children_count' => 'تعداد کودکان',
//                'group.women_only_group' => 'گروه زنانه',
//                'group.staying_duration_day' => 'مدت اقامت',
//                'group.admins' => 'admin',
//                'group.map.lat'=> 'Latitude',
//                'group.map.lng'=> 'Longitude',
            ]);

        $data = $request->get('group');

        $data['team_leader_phone'] = $this->convert2english($data['team_leader_phone']);
        $data['team_leader_national_code'] = $this->convert2english($data['team_leader_national_code']);
//        $data['team_leader_birthdate'] = $this->convert2english($data['team_leader_birthdate']);
//        $data['men_count'] = $this->convert2english($data['men_count']);
//        $data['women_count'] = $this->convert2english($data['women_count']);
//        $data['children_count'] = $this->convert2english($data['children_count']);
//        $data['staying_duration_day'] = $this->convert2english($data['staying_duration_day']);

        $tags = $data['tags'] ?? [];


        if(empty($data['men_count']) || $data['men_count']==0) {
            $tags[] = "4";
        }

//        if(empty($group)) {
//            $this->group->fill($data)->save();
//            $this->group->tags()->sync($tags);
//        } else {
            $group->fill($data)->save();
            $group->tags()->sync($tags);
//        }


//        $group->admins()->sync($tags);

        Alert::info('گروه با موفقیت ایجاد شد');

        return redirect()->route('platform.pilgrim.group.list');
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
