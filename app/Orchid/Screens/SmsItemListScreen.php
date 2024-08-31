<?php

namespace App\Orchid\Screens;

use App\Models\Pilgrim;
use App\Models\Sms;
use App\Models\SmsItem;
use App\Orchid\Layouts\SmsItemListLayout;
use App\Orchid\Layouts\SmsListLayout;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

use Kavenegar\Exceptions\ApiException;
use Kavenegar\Laravel\Message\KavenegarMessage;
use Kavenegar;

class SmsItemListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $sms_id = Route::getCurrentRoute()->sms_id;

//        var_dump($sms_id);
//        die();

        return [
            'items' => SmsItem::where('sms_id', $sms_id)->latest()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'پیامک';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $sms_id = Route::getCurrentRoute()->sms_id;
        return [
            Button::make('ارسال پیام')
                ->method('sendSms')
                ->novalidate()
                ->icon('bs.chat-square-dots'),
//                ->route('platform.sms.item.new')
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
            SmsItemListLayout::class
        ];
    }

    /**
     * @param SmsItem $SmsItem
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove($id)
    {
//        var_dump($pilgrim->first_name);
//        die();

        SmsItem::destroy($id);
        $sms_id = Route::getCurrentRoute()->sms_id;
        Alert::info('مخاطب با موفقیت حذف شد');

        return redirect()->route('platform.sms.items.list', ["sms_id" =>  $sms_id]);
    }

    public function sendSms()
    {
        $sms_id = Route::getCurrentRoute()->sms_id;
        $sms = Sms::where("id", $sms_id)->first();
        $items = SmsItem::where("sms_id", $sms_id)->get();

        foreach($items as $contact) {
            $receptor =  $contact->phone;
            $template =  "khadem";
            $type =  "sms";
            $token =  $sms->token1;
            $token2 =  $sms->token2;
            $token3 =  $sms->token3;
            $result = Kavenegar::VerifyLookup($receptor,$token,$token2,$token3,$template,$type);
            $contact->result = $result[0]->statustext;
            $contact->result_code = $result[0]->status;
            $contact->save();
        }

        return redirect()->route('platform.sms.items.list', ["sms_id" =>  $sms_id]);

//        var_dump($sms_id);
//        die();
    }
}
