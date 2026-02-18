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

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Banner Yönetimi';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(12)->schema([
                    // Metin Alanları
                    Section::make('Banner İçerikleri')->columnSpan(8)->schema([
                        TextInput::make('top_text')->label('Üst Metin'),
                        Textarea::make('loop_text')->label('Dönen Metinler (Virgülle ayırın)'),
                        TextInput::make('bottom_text')->label('Alt Metin'),
                        Grid::make(3)->schema([
                            TextInput::make('word1')->label('Kelime 1'),
                            TextInput::make('word2')->label('Kelime 2'),
                            TextInput::make('word3')->label('Kelime 3'),
                        ]),
                    ]),

                    // Görseller ve Yayın Durumu
                    Section::make('Görseller & Durum')->columnSpan(4)->schema([
                        FileUpload::make('img1')->label('Resim 1')->disk('uploads')->directory('hero')->toWebp()->image(),
                        FileUpload::make('img2')->label('Resim 2')->disk('uploads')->directory('hero')->toWebp()->image(),
                        FileUpload::make('img3')->label('Resim 3')->disk('uploads')->directory('hero')->toWebp()->image(),
                        FileUpload::make('img4')->label('Resim 4')->disk('uploads')->directory('hero')->toWebp()->image(),
                        FileUpload::make('img5')->label('Resim 5')->disk('uploads')->directory('hero')->toWebp()->image(),
                        
                        Toggle::make('is_published')
                            ->label('Yayınla')
                            ->helperText('Aktif edilirse diğerleri pasif olur.')
                            ->live()
                            ->afterStateUpdated(function ($state, $record) {
                                if ($state && $record) {
                                    Hero::where('id', '!=', $record->id)->update(['is_published' => false]);
                                }
                            }),
                    ]),
                ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('img1')->label('Görsel 1')->disk('uploads'),
                Tables\Columns\TextColumn::make('top_text')->label('Başlık'),
                Tables\Columns\ToggleColumn::make('is_published')->label('Yayın Durumu'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
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