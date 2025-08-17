<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Models\About;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationLabel = 'Hakkımızda';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralModelLabel = 'Hakkımızda Yönetimi';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Hakkımızda';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        Section::make('Genel Bilgiler')
                            ->schema([
                                TextInput::make('top_title')->label('Üst Başlık')->nullable(),
                                TextInput::make('title')->label('Başlık')->nullable(),
                                RichEditor::make('desc1')->label('Açıklama 1')->nullable(),
                                RichEditor::make('desc2')->label('Açıklama 2')->nullable(),

                                // Yayın Durumu Toggle Butonu
                                Toggle::make('is_published')
                                    ->label('Yayınlandı mı?')
                                    ->default(false)
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $record) {
                                        if ($state) {
                                            // Eğer bir kayıt aktif edilirse, diğer tüm kayıtları pasif yap
                                            \App\Models\About::where('id', '!=', $record->id)->update(['is_published' => false]);
                                        }
                                    }),
                            ])
                            ->columnSpan(12),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('top_title')->label('Üst Başlık'),
                TextColumn::make('title')->label('Başlık'),
                TextColumn::make('desc1')->label('Açıklama 1')->limit(50),
                TextColumn::make('desc2')->label('Açıklama 2')->limit(50),

                // Yayın Durumu Toggle Butonu
                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->afterStateUpdated(function ($state, $record) {
                        if ($state) {
                            // Eğer bir kayıt aktif edilirse, diğer tüm kayıtları pasif yap
                            \App\Models\About::where('id', '!=', $record->id)->update(['is_published' => false]);
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
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
