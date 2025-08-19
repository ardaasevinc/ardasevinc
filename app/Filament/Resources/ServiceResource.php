<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationLabel = 'Hizmetler';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $pluralModelLabel = 'Hizmetler';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Hizmet';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                Section::make('Hizmet Görseli')
                    ->schema([
                        FileUpload::make('icon')
                            ->label('Hizmet İkonu')
                            ->image()
                            ->helperText('100x100 çözünürlüğünde olmalıdır.')
                            ->disk('uploads')
                            ->directory('services')
                            ->nullable(),
                    ])
                    ->columnSpan(4),

                Section::make('Hizmet Detayları')
                    ->schema([
                        TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, $state) {
                                if (!filled($state))
                                    return;
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->helperText('Başlıktan otomatik oluşur, istersen düzenleyebilirsin.')
                            ->rules(['alpha_dash'])
                            ->unique(ignoreRecord: true)
                            ->dehydrateStateUsing(fn($state) => Str::slug((string) $state))
                            ->nullable(),

                        RichEditor::make('desc')
                            ->label('Açıklama')
                            ->nullable(),

                        TextInput::make('item1')->label('Öğe 1')->nullable(),
                        TextInput::make('item2')->label('Öğe 2')->nullable(),
                        TextInput::make('item3')->label('Öğe 3')->nullable(),
                        TextInput::make('item4')->label('Öğe 4')->nullable(),

                        RichEditor::make('desc1')->label('Ek Açıklama 1')->nullable()
                            ->fileAttachmentsDisk('uploads') 
                            ->fileAttachmentsDirectory('service/richeditor'),
                        RichEditor::make('desc2')->label('Ek Açıklama 2')->nullable()
                            ->fileAttachmentsDisk('uploads') 
                            ->fileAttachmentsDirectory('service/richeditor'),
                        RichEditor::make('desc3')->label('Ek Açıklama 3')->nullable()
                            ->fileAttachmentsDisk('uploads') 
                            ->fileAttachmentsDirectory('Service/richeditor'),

                        Toggle::make('is_published')
                            ->label('Yayın Durumu')
                            ->default(true),
                    ])
                    ->columnSpan(8),
            ]),

            Section::make('Deneyim (Experience)')
                ->schema([
                    TextInput::make('number')
                        ->label('Numara')
                        ->numeric()
                        ->nullable(),

                    TextInput::make('number_title')
                        ->label('Numara Başlığı')
                        ->nullable(),
                ])
                ->collapsible(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon')
                    ->label('İkon')
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

                TextColumn::make('desc')
                    ->label('Açıklama')
                    ->limit(50)
                    ->wrap()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('number')
                    ->label('Numara')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('number_title')
                    ->label('Numara Başlığı')
                    ->sortable()
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
