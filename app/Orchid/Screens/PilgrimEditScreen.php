<?php

namespace App\Orchid\Screens;

use App\Models\Pilgrim;
use App\Models\PilgrimGroup;
use App\Orchid\Layouts\PilgrimEditLayout;
use App\Orchid\Layouts\PilgrimGroupEditLayout;
use App\Orchid\Layouts\ProvinceListener;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PilgrimEditScreen extends Screen
{
    /**
     * @var PilgrimGroup
     */
    public $pilgrim;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Pilgrim $pilgrim): iterable
    {
//        $group->load('attachment');
        return [
            'pilgrim' => $pilgrim,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->pilgrim->exists ? 'ویرایش زائر' : 'افزودن زائر جدید';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('ایجاد زائر')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->pilgrim->exists),

            Button::make('ویرایش')
                ->icon('note')
                ->method('update')
                ->canSee($this->pilgrim->exists),

            Button::make('جذف')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->pilgrim->exists),
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
                PilgrimEditLayout::class
            ])
                ->title(__('زائر'))
                ->description('لطفا تمام اطلاعات رو تکمیل کنید'),

//            Layout::block([
//                ProvinceListener::class,
//            ])
//                ->title(__('استان و شهر'))
//                ->description(__('شهر و استان محل سکونت زائر'))

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

        $this->validate(request(), [
            'pilgrim.first_name' => 'required|max:255',
            'pilgrim.last_name' => 'required|max:255',
            'pilgrim.national_code' => 'required|max:255',
            'pilgrim.mobile' => 'max:15',
            'pilgrim.birthdate' => 'max:10',
            'pilgrim.gender' => 'max:1',

        ], [],
            [
                'pilgrim.first_name' => 'نام',
                'pilgrim.last_name'=> 'نام خانوادگی',
                'pilgrim.national_code'=> 'کد ملیه',
                'pilgrim.mobile' => 'شماره همراه',
                'pilgrim.birthdate' => 'تاریخ تولد',
                'pilgrim.gender' => 'جنسیت',
            ]);

        $data = $request->get('pilgrim');

        $group_id = Route::getCurrentRoute()->group;

        $data['mobile'] = $this->convert2english($data['mobile']);
        $data['national_code'] = $this->convert2english($data['national_code']);
        $data['group_id'] = $group_id;

        $tags = $data['tags'] ?? [];


        if(empty($this->group)) {
            $this->pilgrim = new Pilgrim();
        }
        $this->pilgrim->fill($data)->save();
        $this->pilgrim->tags()->sync($tags);


//        $group->admins()->sync($tags);

        Alert::info('زائر جدید با موفقیت ایجاد شد');

        return redirect()->route('platform.pilgrim.list', ["group" =>  $this->pilgrim->group_id]);
    }


    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Pilgrim $pilgrim): RedirectResponse
    {
        $this->validate(request(), [
            'pilgrim.first_name' => 'required|max:255',
            'pilgrim.last_name' => 'required|max:255',
            'pilgrim.national_code' => 'required|max:255',
            'pilgrim.mobile' => 'max:15',
            'pilgrim.birthdate' => 'max:10',
            'pilgrim.gender' => 'max:1',

        ], [],
            [
                'pilgrim.first_name' => 'نام',
                'pilgrim.last_name'=> 'نام خانوادگی',
                'pilgrim.national_code'=> 'کد ملیه',
                'pilgrim.mobile' => 'شماره همراه',
                'pilgrim.birthdate' => 'تاریخ تولد',
                'pilgrim.gender' => 'جنسیت',
            ]);

        $data = $request->get('pilgrim');

        $data['mobile'] = $this->convert2english($data['mobile']);
        $data['national_code'] = $this->convert2english($data['national_code']);

        $tags = $data['tags'] ?? [];


        $pilgrim->fill($data)->save();
        $pilgrim->tags()->sync($tags);

        Alert::info('زائر جدید با موفقیت ایجاد شد');

        return redirect()->route('platform.pilgrim.list', ["group" =>  $pilgrim->group_id]);
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

        Pilgrim::destroy($id);
        $group_id = Route::getCurrentRoute()->group;
        Alert::info('عضو با موفقیت حذف شد');

        return redirect()->route('platform.pilgrim.list', ["group" =>  $group_id]);
    }
}
