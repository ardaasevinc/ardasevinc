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
use Filament\Forms\Set;
use Illuminate\Support\Str;
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

                // SOL PANEL (İçerik)
                Group::make()->schema([
                    Section::make('Hizmet Bilgileri')->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Hizmet Başlığı')
                                ->required()
                                ->live(onBlur: true) // Odak kalktığında slug'ı tetikler
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('URL Uzantısı')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->dehydrated(true) // Kayıt sırasında gönderilmesini sağlar
                                ->helperText('Başlığa göre otomatik oluşturulur, manuel değiştirebilirsiniz.'),
                        ]),

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
                                RichEditor::make('desc1')->label('Ek İçerik 1')->columnSpanFull(),
                                RichEditor::make('desc2')->label('Ek İçerik 2')->columnSpanFull(),
                                RichEditor::make('desc3')->label('Ek İçerik 3')->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('İstatistik & Deneyim')
                            ->icon('heroicon-o-chart-pie')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('number')->label('Sayısal Veri')->numeric(),
                                    TextInput::make('number_title')->label('Veri Başlığı'),
                                ]),
                            ]),

                        Tabs\Tab::make('SEO Ayarları')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('meta_title')->label('SEO Başlığı'),
                                TextInput::make('meta_keywords')->label('Anahtar Kelimeler'),
                                Forms\Components\Textarea::make('meta_description')
                                    ->label('SEO Açıklaması')
                                    ->columnSpanFull(),
                            ]),
                    ]),
                ])->columnSpan(8),

                // SAĞ PANEL (Görsel ve Durum)
                Group::make()->schema([
                    Section::make('Yayın Ayarları')->schema([
                        FileUpload::make('icon')
                            ->label('Hizmet İkonu')
                            ->image()
                            ->imageEditor()
                            ->toWebp()
                            ->disk('uploads')
                            ->directory('services')
                            ->columnSpanFull(),

                        TextInput::make('sort_order')
                            ->label('Sıralama')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_published')
                            ->label('Yayında mı?')
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
                    ->disk('uploads'),

                TextColumn::make('title')
                    ->label('Hizmet Adı')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('number')
                    ->label('Veri')
                    ->description(fn (Service $record): string => $record->number_title ?? '')
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Durum'),

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
            ]);
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