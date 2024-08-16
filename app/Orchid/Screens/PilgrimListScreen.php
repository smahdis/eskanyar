<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\PilgrimListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PilgrimListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'زائرین';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('افزودن زائر جدید')
                ->icon('pencil')
                ->route('platform.place.edit')
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
            PilgrimListLayout::class
        ];
    }
}
