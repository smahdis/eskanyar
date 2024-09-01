<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\DateFilter;
use App\Orchid\Filters\ParticipatorFilter;
use App\Orchid\Filters\PilgrimFilter;
use App\Orchid\Filters\PilgrimGroupFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class PilgrimFiltersLayout extends Selection
{
//    public $template = self::TEMPLATE_LINE; // or self::TEMPLATE_LINE

    /**
     * @return string[]|Filter[]
     */
    public function filters(): array
    {
        return [
            PilgrimFilter::class,
//            DateFilter::class
        ];
    }
}
