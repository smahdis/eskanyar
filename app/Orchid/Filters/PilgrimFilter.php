<?php

namespace App\Orchid\Filters;

use App\Models\Invitee;
use App\Models\Participator;
use App\Models\Pilgrim;
use App\Models\PilgrimGroup;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class PilgrimFilter extends Filter
{
    public $parameters = ['first_name', 'last_name', 'national_code', 'mobile'];

    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return '';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['first_name', 'last_name', 'national_code', 'mobile'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        if($this->request->get('first_name')) {
            $builder = $builder->where('first_name', $this->request->get('first_name'));
        }

        if($this->request->get('last_name')) {
            $builder = $builder->where('last_name', $this->request->get('last_name'));
        }

        if($this->request->get('national_code')) {
            $builder = $builder->where('national_code', $this->request->get('national_code'));
        }

        if($this->request->get('mobile')) {
            $builder = $builder->where('mobile', $this->request->get('mobile'));
        }

//        if($this->request->get('status')) {
//            $builder = $builder->where('status', $this->request->get('status'));
//        }

        return $builder;

    }


    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [

                  Select::make('first_name')
                      ->fromModel(Pilgrim::class, 'first_name','first_name')
                      ->empty()
                      ->value($this->request->get('first_name'))
                      ->title(__('نام')),

                  Select::make('last_name')
                      ->fromModel(Pilgrim::class, 'last_name','last_name')
                      ->empty()
                      ->value($this->request->get('last_name'))
                      ->title(__('نام خانوادگی')),

                  Select::make('national_code')
                      ->fromModel(Pilgrim::class, 'national_code','national_code')
                      ->empty()
                      ->value($this->request->get('national_code'))
                      ->title(__('کد ملی')),

                  Select::make('mobile')
                      ->fromModel(Pilgrim::class, 'mobile','mobile')
                      ->empty()
                      ->value($this->request->get('mobile'))
                      ->title(__('موبایل')),

//                  Select::make('email')
//                      ->fromModel(Participator::class, 'email', 'email')
//                      ->empty()
//                      ->value($this->request->get('email'))
//                      ->title(__('Email')),

//                  DateRange::make('created_at')->title('Date'),

//                    Select::make('status')
//                        ->options([
//                            '0' => 'Not Visited',
//                            '1' => 'Started',
//                            '2' => 'Finished',
//                        ])
//                        ->empty('All')
//                        ->title('Status')
//                        ->help('Allow search bots to index')
        ];
    }
}
