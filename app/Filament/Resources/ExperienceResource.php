<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Models\Experience;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationLabel = 'Rakamsal Veriler';
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar'; // İkon güncellendi
    protected static ?string $pluralModelLabel = 'Deneyim & İstatistikler';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'İstatistik';

    // Global Search: Başlık üzerinden arama yapılabilir
    protected static ?string $recordTitleAttribute = 'number_title';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Veri Detayları')
                    ->description('Ana sayfadaki sayaç alanları için rakamsal verileri girin.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('number')
                                ->label('Sayısal Değer')
                                ->placeholder('Örn: 12, 150, 10')
                                ->numeric()
                                ->required()
                                ->helperText('Sadece rakam giriniz.'),

                            TextInput::make('number_title')
                                ->label('Veri Başlığı')
                                ->placeholder('Örn: Yıllık Deneyim, Proje Sayısı')
                                ->required()
                                ->maxLength(255),
                            
                            TextInput::make('sort_order')
                                ->label('Sıralama')
                                ->numeric()
                                ->default(0),

                            Toggle::make('is_published')
                                ->label('Yayınla')
                                ->default(true)
                                ->onColor('success'),
                        ]),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),

                TextColumn::make('number')
                    ->label('Değer')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                
                TextColumn::make('number_title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Eklenme')
                    ->dateTime('d.m.Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc') // Varsayılan sıralama
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Yayın Durumu')
                    ->placeholder('Tümü'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Toplu yayınlama aksiyonu
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Seçilenleri Yayınla')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_published' => true])),
                ]),
            ])
            ->emptyStateHeading('Henüz bir veri girişi yapılmamış.')
            ->emptyStateDescription('Ana sayfadaki sayaçları yönetmek için yeni bir veri ekleyin.');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'number_title'];
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