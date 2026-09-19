<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DocumentationOverviewWidget extends Widget
{
    protected string $view = 'filament.widgets.documentation-overview-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -5; // Show at the top of Dashboard
}
