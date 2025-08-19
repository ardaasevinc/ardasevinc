<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CvSubmissionResource\Pages;
use App\Models\CvSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CvSubmissionResource extends Resource
{
    protected static ?string $model = CvSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)->schema([

                    FileUpload::make('photo_path')
                        ->label('Fotoğraf')
                        ->image()
                        ->disk('uploads')
                        ->directory('cv/photos')
                        ->visibility('public')
                        ->columnSpan(4),

                    Grid::make()->columns(1)->columnSpan(8)->schema([
                        TextInput::make('name')->label('Ad Soyad')->required(),
                        TextInput::make('email')->label('E-posta')->email()->required(),
                        TextInput::make('phone')->label('Telefon'),
                        TextInput::make('birth_date')->label('Doğum Tarihi')->type('date'),
                        Textarea::make('career_goal')->label('Kariyer Hedefi'),

                        // ---- Eğitim
                        Repeater::make('education')
                            ->label('Eğitim')
                            ->schema([
                                TextInput::make('school')->label('Okul'),
                                TextInput::make('department')->label('Bölüm'),
                                TextInput::make('year')->label('Yıl'),
                            ])
                            ->default([])
                            ->nullable()
                            ->afterStateHydrated(function (Repeater $component, $state) {
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    $component->state(is_array($decoded) ? $decoded : []);
                                } elseif (!is_array($state)) {
                                    $component->state([]);
                                }
                            })
                            ->dehydrateStateUsing(fn ($state) => is_array($state) ? array_values($state) : [])
                            ->columnSpanFull(),

                        // ---- İş Deneyimi
                        Repeater::make('experience')
                            ->label('İş Deneyimi')
                            ->schema([
                                TextInput::make('company')->label('Şirket'),
                                TextInput::make('position')->label('Pozisyon'),
                                TextInput::make('year')->label('Yıl'),
                                Textarea::make('desc')->label('Açıklama'),
                            ])
                            ->default([])
                            ->nullable()
                            ->afterStateHydrated(function (Repeater $component, $state) {
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    $component->state(is_array($decoded) ? $decoded : []);
                                } elseif (!is_array($state)) {
                                    $component->state([]);
                                }
                            })
                            ->dehydrateStateUsing(fn ($state) => is_array($state) ? array_values($state) : [])
                            ->columnSpanFull(),

                        // ---- Diller
                        Repeater::make('languages')
                            ->label('Diller')
                            ->schema([
                                TextInput::make('name')->label('Dil'),
                                TextInput::make('level')->label('Seviye'),
                            ])
                            ->default([])
                            ->nullable()
                            ->afterStateHydrated(function (Repeater $component, $state) {
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    $component->state(is_array($decoded) ? $decoded : []);
                                } elseif (!is_array($state)) {
                                    $component->state([]);
                                }
                            })
                            ->dehydrateStateUsing(fn ($state) => is_array($state) ? array_values($state) : [])
                            ->columnSpanFull(),

                        // ---- Sertifikalar
                        Repeater::make('certificates')
                            ->label('Sertifikalar')
                            ->schema([
                                TextInput::make('name')->label('Sertifika/Kurs'),
                                TextInput::make('year')->label('Yıl'),
                            ])
                            ->default([])
                            ->nullable()
                            ->afterStateHydrated(function (Repeater $component, $state) {
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    $component->state(is_array($decoded) ? $decoded : []);
                                } elseif (!is_array($state)) {
                                    $component->state([]);
                                }
                            })
                            ->dehydrateStateUsing(fn ($state) => is_array($state) ? array_values($state) : [])
                            ->columnSpanFull(),

                        Textarea::make('hobbies')->label('Hobiler')->nullable(),
                        Textarea::make('references')->label('Referanslar')->nullable(),
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Ad Soyad')->searchable()->sortable(),
                TextColumn::make('email')->label('E-posta')->searchable(),
                TextColumn::make('phone')->label('Telefon')->toggleable(),
                TextColumn::make('created_at')->dateTime()->label('Oluşturulma'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListCvSubmissions::route('/'),
            'create' => Pages\CreateCvSubmission::route('/create'),
            'edit'   => Pages\EditCvSubmission::route('/{record}/edit'),
        ];
    }
}
