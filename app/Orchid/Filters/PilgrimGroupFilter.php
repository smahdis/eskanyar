<?php

namespace App\Orchid\Filters;

use App\Models\Invitee;
use App\Models\Participator;
use App\Models\PilgrimGroup;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class PilgrimGroupFilter extends Filter
{
    public $parameters = ['team_leader_lastname', 'team_leader_phone'];

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
        return ['team_leader_lastname', 'team_leader_phone'];
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
        if($this->request->get('team_leader_lastname')) {
            $builder = $builder->where('team_leader_lastname', $this->request->get('team_leader_lastname'));
        }

        if($this->request->get('team_leader_phone')) {
            $builder = $builder->where('team_leader_phone', $this->request->get('team_leader_phone'));
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

                  Select::make('team_leader_lastname')
                      ->fromModel(PilgrimGroup::class, 'team_leader_lastname','team_leader_lastname')
                      ->empty()
                      ->value($this->request->get('team_leader_lastname'))
                      ->title(__('نام یا نام خانوادگی')),

                  Select::make('team_leader_phone')
                      ->fromModel(PilgrimGroup::class, 'team_leader_phone','team_leader_phone')
                      ->empty()
                      ->value($this->request->get('team_leader_phone'))
                      ->title(__('شماره تماس')),

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
