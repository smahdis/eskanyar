<?php

namespace App\Orchid\Screens;

use App\Models\PilgrimGroup;
use App\Models\Sms;
use App\Models\SmsItem;
use App\Orchid\Layouts\PilgrimGroupEditLayout;
use App\Orchid\Layouts\ProvinceListener;
use App\Orchid\Layouts\SmsEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SmsEditScreen extends Screen
{
    /**
     * @var Sms
     */
    public $sms;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Sms $sms): iterable
    {
//        $group->load('attachment');
        return [
            'sms' => $sms,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->sms->exists ? 'ویرایش پیامک' : 'ایجاد پیامک گروهی جدید';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('ایجاد پیامک گروهی')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->sms->exists),

            Button::make('ویرایش')
                ->icon('note')
                ->method('update')
                ->canSee($this->sms->exists),

            Button::make('جذف')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->sms->exists),
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
                SmsEditLayout::class
            ])
                ->title(__('پیامک گروهی جدید'))
                ->description('لطفا تمام اطلاعات رو تکمیل کنید'),
        ];
    }

    function convert2english($string)
    {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string = str_replace($persianDecimal, $newNumbers, $string);
        $string = str_replace($arabicDecimal, $newNumbers, $string);
        $string = str_replace($arabic, $newNumbers, $string);
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
            'sms.title' => 'required|max:255',
            'sms.template' => 'required|max:255',
            'sms.contacts' => 'required',
            'sms.token1' => 'required',

        ], [],
            [
                'sms.title' => 'عنوان',
                'sms.template' => 'الگو',
                'sms.contacts' => 'مخاطبین',
                'sms.token1' => 'توکن 1',
            ]);

        $data = $request->get('sms');

        if (empty($this->sms)) {
            $this->sms = new Sms();
        }
        $this->sms->fill($data)->save();

        $contacts = preg_split('/\r\n|\r|\n/', $this->sms->contacts);

        foreach($contacts as $contact){
            $SmsItem = new SmsItem();
            $SmsItem->phone = $contact;
            $SmsItem->sms_id =  $this->sms->id;
            $SmsItem->save();
        }

//        $group->admins()->sync($tags);

        Alert::info('پیامک گروهی با موفقیت ایجاد شد');

        return redirect()->route('platform.sms.items.list', ['sms_id' => $this->sms->id]);
    }


    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Sms $sms): RedirectResponse
    {
        $this->validate(request(), [
            'sms.title' => 'required|max:255',
            'sms.template' => 'required|max:255',
            'sms.contacts' => 'required',
            'sms.token1' => 'required',

        ], [],
            [
                'sms.title' => 'عنوان',
                'sms.template' => 'الگو',
                'sms.contacts' => 'مخاطبین',
                'sms.token1' => 'توکن 1',
            ]);

        $data = $request->get('sms');

        if (empty($this->sms)) {
            $this->sms = new PilgrimGroup();
        }
        $this->sms->fill($data)->save();

        Alert::info('پیامک با موفقیت ایجاد شد');

        return redirect()->route('platform.sms.list');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove($id)
    {

        Sms::destroy($id);
        Alert::info('پیامک با موفقیت حذف شد');

        return redirect()->route('platform.sms.list');
    }
}
