<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IconResource\Pages;
use App\Models\Icon;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Group;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class IconResource extends Resource
{
    protected static ?string $model = Icon::class;
    protected static ?string $navigationLabel = 'Reklam İkonları';
    protected static ?string $navigationIcon = 'heroicon-o-squares-plus'; // Daha uygun bir ikon
    protected static ?string $pluralModelLabel = 'Reklam İkonları (3lü)';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Reklam İkonu';

    // Global Search: Başlık veya açıklama üzerinden arama yapılabilir
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // Sol taraf: Görsel ve Yayın Ayarları (columnSpan 4)
                        Group::make()
                            ->schema([
                                Section::make('Görsel')
                                    ->schema([
                                        FileUpload::make('icon')
                                            ->label('İkon / Resim')
                                            ->image()
                                            ->helperText('Önerilen boyut: 100x100 piksel.')
                                            ->directory('icons')
                                            ->disk('uploads')
                                            ->imageEditor()
                                            ->required(),
                                    ]),
                                
                                Section::make('Durum ve Sıra')
                                    ->schema([
                                        TextInput::make('sort_order')
                                            ->label('Görüntüleme Sırası')
                                            ->numeric()
                                            ->default(0),

                                        Toggle::make('is_published')
                                            ->label('Yayına Al')
                                            ->default(true)
                                            ->onColor('success'),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // Sağ taraf: Metin İçerikleri (columnSpan 8)
                        Section::make('İçerik Detayları')
                            ->description('İkonun başlık, slug ve açıklama metinlerini düzenleyin.')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Başlık')
                                    ->required()
                                     ->toWebp()
                                    ->image()
                                    ->imageEditor()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $set('slug', Str::slug((string) $state));
                                    }),

                                TextInput::make('slug')
                                    ->label('URL Uzantısı (Slug)')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Başlıktan otomatik oluşturulur.'),

                                Textarea::make('desc')
                                    ->label('Kısa Açıklama')
                                    ->rows(4)
                                    ->nullable(),
                            ])
                            ->columnSpan(8),
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

                ImageColumn::make('icon')
                    ->label('İkon')
                   
                    ->circular()
                    ->disk('uploads'),

                TextColumn::make('title')
                    ->label('Başlık')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc') // Varsayılan sıralama
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Yayın Durumu'),
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
            ->emptyStateHeading('Henüz bir reklam ikonu eklenmemiş.');
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIcons::route('/'),
            'create' => Pages\CreateIcon::route('/create'),
            'edit' => Pages\EditIcon::route('/{record}/edit'),
        ];
    }
}