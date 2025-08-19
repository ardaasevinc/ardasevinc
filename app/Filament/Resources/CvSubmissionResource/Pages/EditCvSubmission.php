<?php

namespace App\Filament\Resources\CvSubmissionResource\Pages;

use App\Filament\Resources\CvSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCvSubmission extends EditRecord
{
    protected static string $resource = CvSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
