<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Models\Hero;
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

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;
    protected static ?string $navigationLabel = 'Ana Sayfa Banner';
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $pluralModelLabel = 'Banner İçerikleri';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Banner';

    // Global Search: Anahtar kelimeler veya üst metin üzerinden arama


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // Sol taraf: Metinler ve Ayarlar (columnSpan 8)
                        Group::make()
                            ->schema([
                                Section::make('Metin İçerikleri')
                                    ->description('Banner alanındaki başlıkları ve kelimeleri düzenleyin.')
                                    ->schema([
                                        TextInput::make('top_text')->label('Üst Metin')->placeholder('Örn: Hoş Geldiniz')->columnSpanFull(),
                                        Textarea::make('loop_text')->label('Dönen Metin')->placeholder('Örn: Tasarımcı, Geliştirici, Freelancer')->rows(3)->columnSpanFull(),
                                        TextInput::make('bottom_text')->label('Alt Metin')->columnSpanFull(),
                                        
                                        Grid::make(3)->schema([
                                            TextInput::make('word1')->label('Vurgulu Kelime 1'),
                                            TextInput::make('word2')->label('Vurgulu Kelime 2'),
                                            TextInput::make('word3')->label('Vurgulu Kelime 3'),
                                        ]),
                                    ]),
                            ])
                            ->columnSpan(8),

                        // Sağ taraf: Görseller ve Yayın Durumu (columnSpan 4)
                        Group::make()
                            ->schema([
                                Section::make('Banner Görselleri')
                                    ->schema([
                                        FileUpload::make('img1')->label('Ana Görsel')->disk('uploads')->directory('hero')->image()->imageEditor()->toWebp(),
                                        FileUpload::make('img2')->label('Resim 2')->disk('uploads')->directory('hero')->image()->imageEditor()->toWebp(),
                                        FileUpload::make('img3')->label('Resim 3')->disk('uploads')->directory('hero')->image()->imageEditor()->toWebp(),
                                        FileUpload::make('img4')->label('Resim 4')->disk('uploads')->directory('hero')->image()->imageEditor()->toWebp(),
                                        FileUpload::make('img5')->label('Resim 5')->disk('uploads')->directory('hero')->image()->imageEditor()->toWebp(),
                                    ])->collapsible(),

                                Section::make('Yayın Durumu')
                                    ->schema([
                                        Toggle::make('is_published')
                                            ->label('Bu Banner\'ı Yayınla')
                                            ->helperText('Aktif edilirse diğer bannerlar otomatik olarak gizlenir.')
                                            ->default(false)
                                            ->live()
                                            ->afterStateUpdated(function ($state, $record) {
                                                if ($state && $record) {
                                                    Hero::where('id', '!=', $record->id)->update(['is_published' => false]);
                                                }
                                            }),
                                    ]),
                            ])
                            ->columnSpan(4),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                ImageColumn::make('img1')->label('Kapak')->circular()->disk('uploads'),
                
                TextColumn::make('top_text')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('word1')
                    ->label('Kelimeler')
                    ->formatStateUsing(fn ($record) => "{$record->word1}, {$record->word2}, {$record->word3}")
                    ->badge()
                    ->color('info'),

                ToggleColumn::make('is_published')
                    ->label('Yayında')
                    ->afterStateUpdated(function ($state, $record) {
                        if ($state) {
                            Hero::where('id', '!=', $record->id)->update(['is_published' => false]);
                        }
                    }),

                TextColumn::make('updated_at')
                    ->label('Güncelleme')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_published')->label('Yayın Durumu'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Henüz bir banner içeriği yok.');
    }

  
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}