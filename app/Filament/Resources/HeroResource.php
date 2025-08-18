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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;
    protected static ?string $navigationLabel = 'Banner';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralModelLabel = 'Banner';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Banner';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([

                Grid::make(12)

                    ->schema([
                        // Sol tarafta resimler (columnSpan 4)
                        Section::make('Resimler')
                            ->schema([
                                FileUpload::make('img1')
                                    ->label('Resim 1')
                                    ->disk('uploads')
                                    
                                    ->image()

                                    ->directory('hero')
                                    ->nullable(),
                                FileUpload::make('img2')
                                    ->label('Resim 2')
                                    ->disk('uploads')
                                    ->image()

                                    ->directory('hero')
                                    ->nullable(),
                                FileUpload::make('img3')
                                    ->label('Resim 3')
                                    ->disk('uploads')
                                    ->image()

                                    ->directory('hero')
                                    ->nullable(),
                                FileUpload::make('img4')
                                    ->label('Resim 4')
                                    ->disk('uploads')
                                    ->image()

                                    ->directory('hero')
                                    ->nullable(),

                                FileUpload::make('img5')
                                    ->label('Resim 5')
                                    ->disk('uploads')
                                    ->image()

                                    ->directory('hero')
                                    ->nullable(),
                            ])


                            ->columnSpan(4),

                        // Sağ tarafta metinler ve yayın durumu (columnSpan 8)
                        Section::make('Metin Alanları')
                            ->schema([
                                Textarea::make('loop_text')->label('Dönen Metin')->nullable(),
                                TextInput::make('top_text')->label('Üst Metin')->nullable(),
                                TextInput::make('bottom_text')->label('Alt Metin')->nullable(),
                                TextInput::make('word1')->label('Kelime 1')->nullable(),
                                TextInput::make('word2')->label('Kelime 2')->nullable(),
                                TextInput::make('word3')->label('Kelime 3')->nullable(),



                            ])
                            ->columnSpan(8),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                // TextColumn::make('loop_text')->label('Dönen Metin')->limit(30),
                // TextColumn::make('top_text')->label('Üst Metin'),
                // TextColumn::make('bottom_text')->label('Alt Metin'),

                ImageColumn::make('img1')->label('Resim 1')->size(50)->disk('uploads'),
                ImageColumn::make('img2')->label('Resim 2')->size(50)->disk('uploads'),
                ImageColumn::make('img3')->label('Resim 3')->size(50)->disk('uploads'),
                ImageColumn::make('img4')->label('Resim 4')->size(50)->disk('uploads'),
                ImageColumn::make('img5')->label('Resim 5')->size(50)->disk('uploads'),

                TextColumn::make('word1')->label('Kelime 1'),
                TextColumn::make('word2')->label('Kelime 2'),
                TextColumn::make('word3')->label('Kelime 3'),

                // Yayın Durumu Toggle Butonu
                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->default(false)
                    ->afterStateUpdated(function ($state, $record) {
                        if (!$record || !$record->id) {
                            return; // Eğer kayıt yoksa işlem yapma
                        }

                        if ($state) {
                            \App\Models\Hero::where('id', '!=', $record->id)->update(['is_published' => false]);
                        }
                    }),



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
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}
