<?php

namespace App\Orchid\Layouts;

use App\Models\ProvinceCity;
use App\Models\Section;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;

class ProvinceListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'group.province_id',
        'group.city_id',
    ];

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    protected function layouts(): iterable
    {
//        var_dump($this->query->get('group.province'));
//        die();
        return [
            Layout::rows([
                Select::make('group.province_id')
    //                ->fromModel(ProvinceCity::class, 'title')
                    ->value($this->query->get('selected_province'))
                    ->empty('انتخاب کنید')
                    ->fromQuery(ProvinceCity::where("parent", $this->query->get('test') ?? 0)
//                        ->where("id", $this->query->has('selected_province') ? $this->query->get('selected_province') : $this->query->get('group.province'))
                        , 'title')
    //                ->multiple()
                    ->title(__('انتخاب استان')),

                Select::make('group.city_id')
                    ->value($this->query->get('selected_city'))
                    ->empty('انتخاب کنید')
                    ->fromQuery(ProvinceCity::when($this->query->get('selected_province'), function($query, $selected_province) {
                        return $query->where('parent', $selected_province);
                    }, function ($query) {
                        return $query->where('parent', $this->query->get('group.province_id'));
                    }), 'title')

//                    ->fromQuery(ProvinceCity::where("parent", $this->query->get('selected_province')), 'title')
//                    ->multiple()
                    ->title(__('انتخاب شهر')),
            ]),
        ];
    }

    /**
     * Update state
     *
     * @param \Orchid\Screen\Repository $repository
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Orchid\Screen\Repository
     */
    public function handle(Repository $repository, Request $request): Repository
    {
        $test = 0;
        $province = $request->input('group.province_id');
        $city = $request->input('group.city_id');

        return $repository
//            ->set('selected_province', $province)
            ->set('selected_city', $city)
            ->set('selected_province', $province)
            ->set('test', $test);
    }
}
