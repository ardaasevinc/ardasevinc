<?php

namespace App\Filament\Resources\CvSubmissionResource\Pages;

use App\Filament\Resources\CvSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCvSubmissions extends ListRecords
{
    protected static string $resource = CvSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
