<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioPostResource\Pages;
use App\Models\PortfolioPost;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Group;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class PortfolioPostResource extends Resource
{
    protected static ?string $model = PortfolioPost::class;
    protected static ?string $navigationLabel = 'Projeler';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $pluralModelLabel = 'Projeler';
    protected static ?string $navigationGroup = 'Portfolyo Yönetimi';
    protected static ?string $modelLabel = 'Proje';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                // SOL KOLON: İçerik ve Galeri
                Group::make()->schema([
                    Section::make('Proje Detayları')
                        ->schema([
                            TextInput::make('title')
                                ->label('Proje Başlığı')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, $state) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('URL Uzantısı (Slug)')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('Proje adından otomatik üretilir.'),

                            RichEditor::make('desc')
                                ->label('Proje Açıklaması')
                                ->fileAttachmentsDisk('uploads')
                                ->fileAttachmentsDirectory('portfolio/richeditor')
                                ->columnSpanFull(),
                        ]),

                    Section::make('Proje Galerisi')
                        ->description('Fotoğrafları topluca sürükleyip bırakabilir ve sıralayabilirsiniz.')
                        ->schema([
                            FileUpload::make('media') // Modeldeki 'media' ilişkisini kullanır
                                ->relationship('media', 'media_path') // İlişki adı ve kaydedilecek sütun
                                ->label('Galeri Resimleri')
                                ->multiple() // Çoklu yükleme aktif
                                ->reorderable() // Sürükle-bırak sıralama aktif
                                ->appendFiles() // Yeni eklenenleri sona ekler
                                ->image()
                                ->imageEditor()
                                ->toWebp()
                                ->disk('uploads')
                                ->directory('portfolio/media')
                                ->orderColumn('sort_order') // Sıralama bilgisini bu sütuna yazar
                                ->columnSpanFull(),
                        ]),
                ])->columnSpan(8),

                // SAĞ KOLON: Ayarlar ve Kapak Görselleri
                Group::make()->schema([
                    Section::make('Kategori ve Yayın')
                        ->schema([
                            Select::make('portfolio_category_id')
                                ->label('Proje Kategorisi')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            TextInput::make('sort_order')
                                ->label('Genel Görüntüleme Sırası')
                                ->numeric()
                                ->default(0),

                            Toggle::make('is_published')
                                ->label('Yayına Al')
                                ->onColor('success')
                                ->default(true),
                        ]),

                    Section::make('Proje Görselleri')
                        ->schema([
                            FileUpload::make('img1')
                                ->label('Ana Görsel (Kapak)')
                                ->image()
                                ->disk('uploads')
                                ->directory('portfolio')
                                ->imageEditor(),

                            FileUpload::make('img2')
                                ->label('Detay Sayfası Görseli')
                                ->image()
                                ->disk('uploads')
                                ->directory('portfolio')
                                ->imageEditor(),
                        ]),
                ])->columnSpan(4),
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

                ImageColumn::make('img1')
                    ->label('Kapak')
                    ->disk('uploads')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Proje Adı')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Durum')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('portfolio_category_id')
                    ->label('Kategori Filtresi')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')->label('Yayın Durumu'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolioPosts::route('/'),
            'create' => Pages\CreatePortfolioPost::route('/create'),
            'edit' => Pages\EditPortfolioPost::route('/{record}/edit'),
        ];
    }
}