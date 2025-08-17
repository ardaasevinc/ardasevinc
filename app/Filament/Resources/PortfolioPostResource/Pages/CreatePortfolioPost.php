<?php

namespace App\Filament\Resources\PortfolioPostResource\Pages;

use App\Filament\Resources\PortfolioPostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePortfolioPost extends CreateRecord
{
    protected static string $resource = PortfolioPostResource::class;
}
