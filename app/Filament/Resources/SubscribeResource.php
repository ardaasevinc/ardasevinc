<?php


namespace App\Filament\Resources;

use App\Filament\Resources\SubscribeResource\Pages;
use App\Models\Subscribe;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class SubscribeResource extends Resource
{
    protected static ?string $model = Subscribe::class;

   

    protected static ?string $navigationLabel = 'Haberdar ol formu';
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $pluralModelLabel = 'Haberdar ol Formu';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Posta';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('email')
                ->label('E-Posta')
                ->required()
                ->email(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('email')->label('E-Posta')->sortable()->searchable(),
            TextColumn::make('created_at')->label('Abonelik Tarihi')->dateTime(),
            
        ])
         ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);

        
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscribes::route('/'),
        ];
    }
}
