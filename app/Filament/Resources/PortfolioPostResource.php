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
use Illuminate\Support\Str;
use Filament\Forms\Set;

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
                        // Sol: Görseller
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

                        // Sağ: Bilgiler
                        Section::make('Portfolio Bilgileri')
                            ->schema([
                                Select::make('portfolio_category_id')
                                    ->label('Kategori')
                                    ->options(
                                        PortfolioCategory::where('is_published', true)
                                            ->pluck('name', 'id')
                                    )
                                    ->searchable()
                                    ->required(),

                                TextInput::make('title')
                                    ->label('Başlık')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (!filled($set('slug'))) {
                                            $set('slug', Str::slug((string) $state));
                                        }
                                    }),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->helperText('Başlıktan otomatik oluşur, istersen düzenleyebilirsin.')
                                    ->rule('alpha_dash')
                                    ->unique(
                                        table: PortfolioPost::class,
                                        column: 'slug',
                                        ignorable: fn($record) => $record
                                    )
                                    ->dehydrateStateUsing(fn($state) => Str::slug((string) $state))
                                    ->nullable(),

                                RichEditor::make('desc')
                                    ->label('Açıklama')
                                    ->nullable(),
                            ])
                            ->columnSpan(8),
                    ]),

                // Galeri
                Section::make('Galeri Resimleri')
                    ->schema([
                        Repeater::make('media')
                            ->label('Galeri Resimleri')
                            ->relationship('media')
                            ->schema([
                                FileUpload::make('media_path')
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
                ImageColumn::make('img1')
                    ->label('Ana Resim')
                    ->size(50)
                    ->toggleable(),

                TextColumn::make('title')
                    ->label('Başlık')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($state) => $state ?? 'Kategori Yok'),

                TextColumn::make('desc')
                    ->label('Açıklama')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),

                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->toggleable(),
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
