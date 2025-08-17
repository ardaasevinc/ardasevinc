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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

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
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // Sol tarafta resim yükleme alanı (columnSpan 4)
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

                        // Sağ tarafta metin alanları (columnSpan 8)
                        Section::make('Hizmet Detayları')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Başlık')
                                    ->required(),

                                RichEditor::make('desc')
                                    ->label('Açıklama')
                                    ->nullable(),

                                TextInput::make('item1')->label('Öğe 1')->nullable(),
                                TextInput::make('item2')->label('Öğe 2')->nullable(),
                                TextInput::make('item3')->label('Öğe 3')->nullable(),
                                TextInput::make('item4')->label('Öğe 4')->nullable(),

                                RichEditor::make('desc1')->label('Ek Açıklama 1')->nullable(),
                                RichEditor::make('desc2')->label('Ek Açıklama 2')->nullable(),
                                RichEditor::make('desc3')->label('Ek Açıklama 3')->nullable(),

                                // Toggle::make('is_published')
                                //     ->label('Yayınlandı mı?')
                                //     ->default(false)
                                //     ->live(),
                            ])
                            ->columnSpan(8),
                    ]),

                // Yeni "Deneyim (Experience)" bölümü
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
                    ->collapsible(), // Bu kartı isteğe bağlı açılır kapanır hale getirdim
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon')->label('İkon')->size(50),
                TextColumn::make('title')->label('Başlık')->sortable(),
                TextColumn::make('desc')->label('Açıklama')->limit(50),
                TextColumn::make('number')->label('Numara')->sortable(),
                TextColumn::make('number_title')->label('Numara Başlığı')->sortable(),

                // Yayın Durumu Toggle Butonu
                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu'),
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
