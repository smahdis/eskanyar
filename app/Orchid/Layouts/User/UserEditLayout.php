<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Models\Place;
use App\Models\Tag;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),


            Relation::make('user.places.')
                ->fromModel(Place::class, 'title')
                ->multiple()
                ->title(__('مسئول اقامتگاه')),
        ];
    }
}
