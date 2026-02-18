<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class PromoBannerWidget extends Widget
{
    // Oluşturduğumuz view dosyasının yolu buraya yazılır:
    protected static string $view = 'filament.widgets.promo-banner-widget';

    // Tam genişlik olması için bunu eklemeyi unutmayın:
    protected int | string | array $columnSpan = 'full';
}