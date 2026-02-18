<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogCategoryResource\Pages;
use App\Models\BlogCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;
    protected static ?string $navigationLabel = 'Blog Kategorileri';
    protected static ?string $navigationIcon = 'heroicon-o-tag'; // Daha uygun bir ikon
    protected static ?string $pluralModelLabel = 'Blog Kategorileri';
    protected static ?string $navigationGroup = 'Haber Yönetimi';
    protected static ?string $modelLabel = 'Blog Kategorisi';

    // Global Search Özelliği (Kategori adı üzerinden arama yapar)
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Kategori Bilgileri')
                    ->description('Kategori detaylarını ve yayın durumunu yönetin.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Kategori Adı')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $set('slug', Str::slug((string) $state));
                                    }),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->rule('alpha_dash')
                                    ->unique(ignoreRecord: true)
                                    ->helperText('URL yapısı için otomatik oluşturulur.'),
                                
                                TextInput::make('sort_order')
                                    ->label('Sıralama')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Kategorilerin listedeki sırasını belirler.'),

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
                    ->sortable()
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->sortable(),

                TextColumn::make('posts_count')
                    ->label('Yazı Sayısı')
                    ->counts('posts') // İlişkili yazı sayısını gösterir
                    ->badge(),

                TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc') // Varsayılan sıralama
            ->filters([
                // Yayın durumuna göre filtreleme
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Yayın Durumu')
                    ->placeholder('Tümü')
                    ->trueLabel('Yayında')
                    ->falseLabel('Yayında Değil'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Görüntüleme ekledik
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Toplu yayınlama özelliği ekledik
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Seçilenleri Yayınla')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_published' => true])),
                    
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Yayından Kaldır')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['is_published' => false])),
                ]),
            ])
            ->emptyStateHeading('Henüz bir kategori bulunmuyor.')
            ->emptyStateDescription('Yeni bir kategori ekleyerek blog yazılarını gruplandırmaya başla.');
    }

    // Global Search'te hangi alanların sonuç getireceğini belirler
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }
}