<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioCategoryResource\Pages;
use App\Models\PortfolioCategory;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class PortfolioCategoryResource extends Resource
{
    protected static ?string $model = PortfolioCategory::class;
    protected static ?string $navigationLabel = 'Portfolyo Kategorileri';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $pluralModelLabel = 'Portfolyo Kategorileri';
    protected static ?string $navigationGroup = 'Portfolyo Yönetimi';
    protected static ?string $modelLabel = 'Kategori';

    // Global Search: Kategori adı üzerinden arama yapar
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Kategori Detayları')
                    ->description('Portfolyo projelerini gruplandırmak için kategori bilgilerini düzenleyin.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Kategori Adı')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Set $set, $state) {
                                    $set('slug', Str::slug((string) $state));
                                }),

                            TextInput::make('slug')
                                ->label('URL Uzantısı (Slug)')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('Kategori adından otomatik üretilir.'),

                            TextInput::make('sort_order')
                                ->label('Sıralama')
                                ->numeric()
                                ->default(0),

                            Toggle::make('is_published')
                                ->label('Yayın Durumu')
                                ->onColor('success')
                                ->default(true),
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

                TextColumn::make('name')
                    ->label('Kategori Adı')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('projects_count')
                    ->label('Proje Sayısı')
                    ->counts('projects') // Modelde projects() ilişkisi olduğunu varsayıyoruz
                    ->badge()
                    ->color('info'),

                ToggleColumn::make('is_published')
                    ->label('Durum')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Eklenme')
                    ->dateTime('d.m.Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Yayın Durumu'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Seçilenleri Yayınla')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_published' => true])),
                ]),
            ])
            ->emptyStateHeading('Henüz bir kategori yok.')
            ->emptyStateDescription('Yeni bir portfolyo kategorisi ekleyerek projelerini sergilemeye başla.');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
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