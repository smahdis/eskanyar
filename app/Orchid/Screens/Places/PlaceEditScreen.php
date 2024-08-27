<?php

namespace App\Orchid\Screens\Places;


use App\Models\Place;
use App\Models\Pool;
use App\Orchid\Layouts\Branch\BranchEditLayout;
use App\Orchid\Layouts\Branch\BranchEditTranslationEnglishLayout;
use App\Orchid\Layouts\Branch\BranchEditTranslationGeorgianLayout;
use App\Orchid\Layouts\PlaceEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Locale;

class PlaceEditScreen extends Screen
{
    /**
     * @var Place
     */
    public $place;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Place $place): iterable
    {
//        $place->load('attachment');
        return [
            'place' => $place,
            'place.map' => [
                'lat' => $place->lat ? $branch->lat : "36.2972",
                'lng' => $place->lng ? $branch->lng : "59.6067",
            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->place->exists ? 'ویرایش مکان' : 'افزودن مکان جدید';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('ایجاد مکان')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->place->exists),

            Button::make('ویرایش')
                ->icon('note')
                ->method('update')
                ->canSee($this->place->exists),

            Button::make('جذف')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->place->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
//        var_dump($this->place);
//        die();

        return [
            Layout::block([
                PlaceEditLayout::class
            ])
                ->title(__('مکان'))
                ->description('لطفا تمام اطلاعات رو تکمیل کنید'),

//            Layout::block([
//                BranchEditLayout::class,
//            ])
//                ->title(__('Other Branch Info'))
//                ->description('These section is common between all languages and does not require translation.')

        ];
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
            'place.title' => 'required|max:255',
            'place.description' => 'required|max:2048',
            'place.address' => 'required|max:512',
            'place.capacity' => 'required',
            'place.parking_capacity' => 'required|max:255',
            'place.shrine_distance' => 'required|max:255',
//            'place.admins' => 'required|max:255',
//            'place.map.lat' => 'required|max:255',
//            'place.map.lng' => 'required|max:255',

        ], [],
            [
                'place.title' => 'Title',
                'place.description'=> 'Description',
                'place.address'=> 'Address',
                'place.capacity' => 'Capacity',
                'place.parking_capacity' => 'Parking Capacity',
                'place.shrine_distance' => 'Shrine Distance',
//                'place.admins' => 'admin',
//                'place.map.lat'=> 'Latitude',
//                'place.map.lng'=> 'Longitude',
            ]);


        $data = $request->get('place');
        $data['lat'] = $data['map']['lat'];
        $data['lng'] = $data['map']['lng'];

//        var_dump($data);
//        die();

        $this->place->fill($data)->save();
//        $place->fill($data)->save();

        $tags = $data['tags'];
        $admins = $data['admins'];
        $this->place->tags()->sync($tags);
        $this->place->admins()->sync($admins);

        Alert::info('اطلاعات با موفقیت ذخیره شد');

        return redirect()->route('platform.place.list');
    }


    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Place $place, Request $request): RedirectResponse
    {

//        var_dump($data);
//        die();

        $this->validate(request(), [
            'place.title' => 'required|max:255',
            'place.description' => 'required|max:2048',
            'place.address' => 'required|max:512',
            'place.capacity' => 'required',
            'place.parking_capacity' => 'required|max:255',
            'place.shrine_distance' => 'required|max:255',
//            'place.admins' => 'required|max:255',
//            'place.map.lat' => 'required|max:255',
//            'place.map.lng' => 'required|max:255',

        ], [],
            [
                'place.title' => 'Title',
                'place.description'=> 'Description',
                'place.address'=> 'Address',
                'place.capacity' => 'Capacity',
                'place.parking_capacity' => 'Parking Capacity',
                'place.shrine_distance' => 'Shrine Distance',
//                'place.admins' => 'admin',
//                'place.map.lat'=> 'Latitude',
//                'place.map.lng'=> 'Longitude',
            ]);


        $data = $request->get('place');
        $data['lat'] = $data['map']['lat'];
        $data['lng'] = $data['map']['lng'];

//        var_dump($data);
//        die();

//        $this->place->fill($data)->save();
        $place->fill($data)->save();

        $tags = $data['tags'];
        $admins = $data['admins'];
        $place->tags()->sync($tags);
        $place->admins()->sync($admins);

        Alert::info('اطلاعات با موفقیت ذخیره شد.');

        return redirect()->route('platform.place.list');
    }
}
