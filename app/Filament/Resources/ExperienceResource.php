<?php


namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Models\Experience;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationLabel = 'Rakamsal Veriler';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $pluralModelLabel = 'Rakamsal Veriler';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Veri';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('number')
                    ->label('Deneyim Yılı / Herhangi bir veri (sayı)')
                    ->numeric()
                    ->required(),

                TextInput::make('number_title')
                    ->label('Deneyim Başlığı / Herhangi bir veri (metin)')
                    ->required(),

               
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label('Deneyim Sayısı')
                    ->sortable(),
                
                TextColumn::make('number_title')
                    ->label('Deneyim Başlığı')
                    ->searchable(),

                    ToggleColumn::make('is_published')
                    ->label('Yayın Durumu'),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}
