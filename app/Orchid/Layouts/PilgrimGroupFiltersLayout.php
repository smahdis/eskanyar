<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\DateFilter;
use App\Orchid\Filters\ParticipatorFilter;
use App\Orchid\Filters\PilgrimGroupFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class PilgrimGroupFiltersLayout extends Selection
{
//    public $template = self::TEMPLATE_LINE; // or self::TEMPLATE_LINE

    /**
     * @return string[]|Filter[]
     */
    public function filters(): array
    {
        return [
            PilgrimGroupFilter::class,
//            DateFilter::class
        ];
    }
}
