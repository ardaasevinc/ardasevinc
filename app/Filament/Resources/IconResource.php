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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class IconResource extends Resource
{
    protected static ?string $model = Icon::class;
    protected static ?string $navigationLabel = 'Reklam İkonları (3lü)';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $pluralModelLabel = 'Reklam İkonları (3lü)';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Reklam';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // Sol tarafta ikon yükleme alanı (columnSpan 4)
                        Section::make('İkon')
                            ->schema([
                                FileUpload::make('icon')
                                    ->label('İkon')
                                    ->image()
                                    ->helperText('İkon boyutu 100x100 piksel olmalıdır.')
                                    ->directory('icons')
                                    ->nullable(),
                            ])
                            ->columnSpan(4),

                        // Sağ tarafta metin alanları (columnSpan 8)
                        Section::make('Metin Alanları')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Başlık')
                                    ->required()
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
                                    ->unique(table: Icon::class, column: 'slug', ignorable: fn($record) => $record)
                                    ->dehydrateStateUsing(fn($state) => Str::slug((string) $state))
                                    ->nullable(),

                                Textarea::make('desc')
                                    ->label('Açıklama')
                                    ->nullable(),

                                Toggle::make('is_published')
                                    ->label('Yayın Durumu')
                                    ->default(true),
                            ])
                            ->columnSpan(8),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon')
                    ->label('İkon')
                    ->size(50)
                    ->disk('uploads')
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

                TextColumn::make('desc')
                    ->label('Açıklama')
                    ->limit(50)
                    ->wrap()
                    ->searchable()
                    ->toggleable(),

                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
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
            'index' => Pages\ListIcons::route('/'),
            'create' => Pages\CreateIcon::route('/create'),
            'edit' => Pages\EditIcon::route('/{record}/edit'),
        ];
    }
}
