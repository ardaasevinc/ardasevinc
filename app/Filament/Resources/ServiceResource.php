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
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationLabel = 'Hizmetler';
    protected static ?string $navigationIcon = 'heroicon-o-command-line';
    protected static ?string $pluralModelLabel = 'Hizmetler';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Hizmet';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Grid::make(12)->schema([

                // SOL PANEL
                Group::make()->schema([

                    Section::make('Hizmet İçeriği')->schema([

                        TextInput::make('title')
                            ->label('Hizmet Başlığı')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('URL Uzantısı (Slug)')
                            ->unique(ignoreRecord: true)
                            ->helperText('Boş bırakırsanız otomatik oluşturulur.'),

                        RichEditor::make('desc')
                            ->label('Ana Açıklama')
                            ->columnSpanFull(),
                    ]),

                    Tabs::make('Detaylı İçerikler')->tabs([

                        Tabs\Tab::make('Özellik Listesi')
                            ->icon('heroicon-o-list-bullet')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('item1')->label('Madde 1'),
                                    TextInput::make('item2')->label('Madde 2'),
                                    TextInput::make('item3')->label('Madde 3'),
                                    TextInput::make('item4')->label('Madde 4'),
                                ]),
                            ]),

                        Tabs\Tab::make('Ek Açıklamalar')
                            ->icon('heroicon-o-document-plus')
                            ->schema([
                                RichEditor::make('desc1')
                                    ->label('Ek İçerik 1')
                                    ->fileAttachmentsDisk('uploads')
                                    ->fileAttachmentsDirectory('services/editor')
                                    ->columnSpanFull(),

                                RichEditor::make('desc2')
                                    ->label('Ek İçerik 2')
                                    ->fileAttachmentsDisk('uploads')
                                    ->fileAttachmentsDirectory('services/editor')
                                    ->columnSpanFull(),

                                RichEditor::make('desc3')
                                    ->label('Ek İçerik 3')
                                    ->fileAttachmentsDisk('uploads')
                                    ->fileAttachmentsDirectory('services/editor')
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('İstatistik (Deneyim)')
                            ->icon('heroicon-o-chart-pie')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('number')
                                        ->label('Sayısal Veri')
                                        ->numeric()
                                        ->minValue(0)
                                        ->placeholder('Örn: 99'),

                                    TextInput::make('number_title')
                                        ->label('Veri Başlığı')
                                        ->placeholder('Örn: Başarılı Proje'),
                                ]),
                            ]),
                    ]),
                ])->columnSpan(8),


                // SAĞ PANEL
                Group::make()->schema([

                    Section::make('Görsel ve Durum')->schema([

                        FileUpload::make('icon')
                            ->label('Hizmet İkonu')
                            ->image()
                            ->imageEditor()
                            ->toWebp()
                            ->disk('uploads')
                            ->directory('services')
                            ->visibility('public')
                            ->nullable(),

                        TextInput::make('sort_order')
                            ->label('Görüntüleme Sırası')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_published')
                            ->label('Yayına Al')
                            ->onColor('success')
                            ->default(true),

                    ]),

                ])->columnSpan(4),
            ]),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),

                ImageColumn::make('icon')
                    ->label('İkon')
                    ->circular()
                    ->disk('uploads')
                    ->defaultImageUrl(url('/images/placeholder.webp')),

                TextColumn::make('title')
                    ->label('Hizmet Adı')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('number')
                    ->label('Veri')
                    ->description(fn (Service $record): string => $record->number_title ?? '')
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Durum')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                TernaryFilter::make('is_published')->label('Yayın Durumu'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('publish')
                        ->label('Seçilenleri Yayınla')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_published' => true])),
                ]),
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'item1', 'item2', 'item3', 'item4'];
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