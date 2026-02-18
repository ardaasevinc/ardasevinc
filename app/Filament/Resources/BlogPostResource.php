<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Group;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationLabel = 'Haberler & Blog';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $pluralModelLabel = 'Blog Yazıları';
    protected static ?string $navigationGroup = 'Haber Yönetimi';
    protected static ?string $modelLabel = 'Blog Yazısı';

    // Global Search: Başlık veya kategori üzerinden arama yapabilirsin
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                Group::make()->schema([
                    Section::make('İçerik Editörü')
                        ->schema([
                            TextInput::make('title')
                                ->label('Başlık')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Set $set, $state) {
                                    $set('slug', Str::slug($state));
                                }),

                            TextInput::make('slug')
                                ->label('URL Uzantısı (Slug)')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('Başlıktan otomatik üretilir.'),

                            RichEditor::make('desc')
                                ->label('Yazı İçeriği')
                                ->required()
                                ->fileAttachmentsDisk('uploads')
                                ->fileAttachmentsDirectory('blog/editor')
                                ->columnSpanFull(),
                        ]),

                    Section::make('Galeri Resimleri')
                        ->schema([
                            Repeater::make('images')
                                ->relationship('media')
                                ->schema([
                                    FileUpload::make('image')
                                        ->label('Görsel')
                                        ->image()
                                        ->imageEditor()
                                            ->toWebp()
                                        ->disk('uploads')
                                        ->directory('blog/media')
                                        ->required(),
                                    TextInput::make('sort_order')
                                        ->label('Sıra')
                                        ->numeric()
                                        ->default(0),
                                ])
                                ->columns(2)
                                ->reorderable('sort_order')
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string => "Resim " . ($state['sort_order'] ?? '')),
                        ]),
                ])->columnSpan(8),

                Group::make()->schema([
                    Section::make('Yayın ve Kategori')
                        ->schema([
                            Select::make('blog_category_id')
                                ->label('Kategori Seçin')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            TextInput::make('sort_order')
                                ->label('Genel Sıralama')
                                ->numeric()
                                ->default(0),

                            Toggle::make('is_published')
                                ->label('Yayına Al')
                                ->onColor('success')
                                ->default(false),
                        ]),

                    Section::make('Kapak Görselleri')
                        ->schema([
                            FileUpload::make('img1')
                                ->label('Ana Görsel')
                                ->image()
                                
                                            ->toWebp()
                                ->disk('uploads')
                                ->directory('blog')
                                ->imageEditor(),

                            FileUpload::make('img2')
                                ->label('Alternatif Görsel')
                                ->image()
                                ->imageEditor()
                                ->toWebp()
                                ->disk('uploads')
                                ->directory('blog'),
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

                ImageColumn::make('img1')
                    ->label('Kapak')
                    ->disk('uploads')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Yayın Durumu')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('blog_category_id')
                    ->label('Kategoriye Göre')
                    ->relationship('category', 'name'),
                
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Yayın Durumu'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
        return ['title', 'slug', 'category.name'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}