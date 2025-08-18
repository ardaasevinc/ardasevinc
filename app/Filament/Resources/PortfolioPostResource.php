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
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
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
    protected static ?string $navigationLabel = 'Portfolyo';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $pluralModelLabel = 'Portfolyo';
    protected static ?string $navigationGroup = 'Portfolyo Yönetimi';
    protected static ?string $modelLabel = 'Portfolyo';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                Section::make('Portfolio Görselleri')
                    ->schema([
                        FileUpload::make('img1')
                            ->label('Ana Resim')
                            ->image()
                            ->disk('uploads')
                            ->directory('portfolio')
                            ->helperText('Bu resim portfolyonun ana görseli olarak kullanılacaktır.')
                            ->nullable(),

                        FileUpload::make('img2')
                            ->label('İkincil Resim')
                            ->image()
                            ->helperText('Bu resim portfolyonun ikincil görseli (Kapak Fotoğrafı) olarak kullanılacaktır.')
                            ->disk('uploads')
                            ->directory('portfolio')
                            ->nullable(),
                    ])
                    ->columnSpan(4),

                Section::make('Portfolio Bilgileri')
                    ->schema([
                        Select::make('portfolio_category_id')
                            ->label('Kategori')
                            ->options(
                                fn () => PortfolioCategory::where('is_published', true)
                                    ->pluck('name', 'id')
                                    ->toArray()
                            )
                            ->searchable()
                            ->required(),

                        TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, $state) {
                                if (!filled($state)) return;
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->helperText('Başlıktan otomatik oluşur, istersen düzenleyebilirsin.')
                            ->rules(['alpha_dash'])
                            ->unique(ignoreRecord: true)
                            ->dehydrateStateUsing(fn ($state) => Str::slug((string) $state))
                            ->nullable(),

                        RichEditor::make('desc')
                            ->label('Açıklama')
                            ->nullable(),

                        Toggle::make('is_published')
                            ->label('Yayın Durumu')
                            ->default(true),
                    ])
                    ->columnSpan(8),
            ]),

            Section::make('Galeri Resimleri')
                ->schema([
                    Repeater::make('media')
                        ->label('Galeri Resimleri')
                        ->relationship('media')
                        ->schema([
                            FileUpload::make('media_path')
                                ->label('Resim')
                                ->image()
                                ->disk('uploads')
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
                    ->disk('uploads')
                    ->size(50)
                    ->toggleable(),

                TextColumn::make('title')
                    ->label('Başlık')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->copyable()
                    ->limit(50)
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ?? 'Kategori Yok')
                    ->toggleable(),

                TextColumn::make('desc')
                    ->label('Açıklama')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),

                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->toggleable(),
            ])
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
