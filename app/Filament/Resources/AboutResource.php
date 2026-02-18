<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Models\About;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationLabel = 'Hakkımızda';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $pluralModelLabel = 'Hakkımızda İçerikleri';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Hakkımızda';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        Section::make('İçerik Bilgileri')
                            ->description('Hakkımızda sayfasındaki metin alanlarını yönetin.')
                            ->schema([
                                TextInput::make('top_title')
                                    ->label('Üst Başlık')
                                    ->placeholder('Örn: Hikayemiz')
                                    ->columnSpanFull(),

                                TextInput::make('title')
                                    ->label('Ana Başlık')
                                    ->placeholder('Örn: Arda Sevinç Kimdir?')
                                    ->required()
                                    ->columnSpanFull(),

                                RichEditor::make('desc1')
                                    ->label('Kısa Açıklama / Giriş')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'link',
                                        'redo',
                                        'undo',
                                    ])
                                    ->columnSpanFull(),

                                RichEditor::make('desc2')
                                    ->label('Detaylı Hakkımızda Metni')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(8),

                        Group::make()
                            ->schema([
                                Section::make('Görsel & Durum')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Hakkımızda Görseli')
                                            ->image()
                                            ->imageEditor()
                                            ->disk('uploads')
                                            ->directory('abouts') // public/uploads/abouts altına gider
                                            ->toWebp() // YAZDIĞIMIZ MAKRO: WebP dönüşümü yapar
                                            ->imageEditor(),

                                        Toggle::make('is_published')
                                            ->label('Bu İçeriği Yayınla')
                                            ->helperText('Aktif edilirse diğer içerikler otomatik olarak yayından kaldırılır.')
                                            ->default(false)
                                            ->live()
                                            ->afterStateUpdated(function ($state, $record) {
                                                if ($state && $record) {
                                                    // Diğer tüm kayıtları yayından kaldır
                                                    About::where('id', '!=', $record->id)->update(['is_published' => false]);
                                                }
                                            }),
                                    ]),
                            ])
                            ->columnSpan(4),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Görsel')
                    ->disk('uploads')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('top_title')
                    ->label('Üst Başlık')
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->afterStateUpdated(function ($state, $record) {
                        if ($state) {
                            // Tablodan toggle yapıldığında da diğerlerini pasif yap
                            About::where('id', '!=', $record->id)->update(['is_published' => false]);
                        }
                    }),

                TextColumn::make('updated_at')
                    ->label('Son Güncelleme')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Yayın Durumu'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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