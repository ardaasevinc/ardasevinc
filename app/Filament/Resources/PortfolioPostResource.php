<?php


namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioPostResource\Pages;
use App\Models\PortfolioPost;
use App\Models\PortfolioCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class PortfolioPostResource extends Resource
{
    protected static ?string $model = PortfolioPost::class;
    protected static ?string $navigationLabel = 'Portfolyo';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $pluralModelLabel = 'Portfolyo';
    protected static ?string $navigationGroup = 'Portfolyo Yönetimi';
    protected static ?string $modelLabel = 'Portfolyo';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // Sol tarafta resim yükleme alanları (columnSpan 4)
                        Section::make('Portfolio Görselleri')
                            ->schema([
                                FileUpload::make('img1')
                                    ->label('Ana Resim')
                                    ->image()
                                    ->directory('portfolio')
                                    ->nullable(),

                                FileUpload::make('img2')
                                    ->label('İkincil Resim')
                                    ->image()
                                    ->directory('portfolio')
                                    ->nullable(),
                            ])
                            ->columnSpan(4),

                        // Sağ tarafta metin alanları (columnSpan 8)
                        Section::make('Portfolio Bilgileri')
                            ->schema([
                                Select::make('portfolio_category_id')
                                    ->label('Kategori')
                                    ->options(PortfolioCategory::where('is_published', true)->get()->pluck('name', 'id')) // Sorgu düzeltildi
                                    ->searchable()
                                    ->required(),

                                TextInput::make('title')
                                    ->label('Başlık')
                                    ->required()
                                    ->maxLength(255),

                                RichEditor::make('desc')
                                    ->label('Açıklama')
                                    ->nullable(),

                                // Toggle::make('is_published')
                                //     ->label('Yayınlandı mı?')
                                //     ->default(false)
                                //     ->live(),
                            ])
                            ->columnSpan(8),
                    ]),

                // Çoklu resimler için ayrı bir bölüm
                Section::make('Galeri Resimleri')
                    ->schema([
                        Repeater::make('media')
                            ->label('Galeri Resimleri')
                            ->relationship('media')
                            ->schema([
                                FileUpload::make('media_path') // `image` yerine `media_path` kullanıldı
                                    ->label('Resim')
                                    ->image()
                                    ->directory('portfolio/media')
                                    ->required(),
                            ])
                            ->defaultItems(0)
                            ->minItems(0)
                            ->maxItems(10),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                ImageColumn::make('img1')->label('Ana Resim')->size(50),
                TextColumn::make('category.name')->label('Kategori')->sortable()->default('Kategori Yok'),
                TextColumn::make('desc')->label('Açıklama')->limit(50),
                ToggleColumn::make('is_published')->label('Yayın Durumu'),
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
            'index' => Pages\ListPortfolioPosts::route('/'),
            'create' => Pages\CreatePortfolioPost::route('/create'),
            'edit' => Pages\EditPortfolioPost::route('/{record}/edit'),
        ];
    }
}
