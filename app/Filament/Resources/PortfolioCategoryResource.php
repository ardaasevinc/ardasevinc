<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioCategoryResource\Pages;
use App\Models\PortfolioCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class PortfolioCategoryResource extends Resource
{
    protected static ?string $model = PortfolioCategory::class;
    protected static ?string $navigationLabel = 'Portfolyo Kategori';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralModelLabel = 'Portfolyo Kategorileri';
    protected static ?string $navigationGroup = 'Portfolyo Yönetimi';
    protected static ?string $modelLabel = 'Portfolyo Kategorisi';
  

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Kategori Adı')->required(),
                // Toggle::make('is_published')->label('Yayınlandı mı?')->default(false),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Kategori Adı')->sortable(),
                ToggleColumn::make('is_published')->label('Yayın Durumu'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolioCategories::route('/'),
            'create' => Pages\CreatePortfolioCategory::route('/create'),
            'edit' => Pages\EditPortfolioCategory::route('/{record}/edit'),
        ];
    }
}
