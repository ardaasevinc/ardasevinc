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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;
    protected static ?string $navigationLabel = 'Bloglar';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralModelLabel = 'Bloglar';
    protected static ?string $navigationGroup = 'Haber Yönetimi';
    protected static ?string $modelLabel = 'Blog';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // Sol tarafta resim yükleme alanları (columnSpan 4)
                        Section::make('Blog Görselleri')
                            ->schema([
                                FileUpload::make('img1')
                                    ->label('Ana Resim')
                                    ->image()
                                    ->directory('blog')
                                    ->nullable(),

                                FileUpload::make('img2')
                                    ->label('İkincil Resim')
                                    ->image()
                                    ->directory('blog')
                                    ->nullable(),
                            ])
                            ->columnSpan(4),

                        // Sağ tarafta metin alanları (columnSpan 8)
                        Section::make('Blog Bilgileri')
                            ->schema([
                                Select::make('blog_category_id')
                                    ->label('Kategori')
                                    ->options(BlogCategory::where('is_published', true)->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),

                                TextInput::make('title')
                                    ->label('Başlık')
                                    ->nullable()
                                    ->live(onBlur: true) // başlıktan slug üret
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (! filled($set('slug'))) {
                                            $set('slug', Str::slug((string) $state));
                                        }
                                    }),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->helperText('Başlıktan otomatik oluşur, istersen düzenleyebilirsin.')
                                    ->rule('alpha_dash')
                                    ->unique(table: BlogPost::class, column: 'slug', ignorable: fn ($record) => $record)
                                    ->dehydrateStateUsing(fn ($state) => Str::slug((string) $state))
                                    ->nullable(),

                                RichEditor::make('desc')
                                    ->label('İçerik')
                                    ->nullable(),

                                Toggle::make('is_published')
                                    ->label('Yayınlandı mı?')
                                    ->default(false)
                                    ->live(),
                            ])
                            ->columnSpan(8),
                    ]),

                // Çoklu resimler için ayrı bir bölüm
                Section::make('Galeri Resimleri')
                    ->schema([
                        Repeater::make('images')
                            ->label('Galeri Resimleri')
                            ->relationship('media')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Resim')
                                    ->image()
                                    ->directory('blog/media')
                                    ->required(),
                            ])
                            ->defaultItems(0)
                            ->minItems(0)
                            ->maxItems(10),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                ImageColumn::make('img1')
                    ->label('Ana Resim')
                    ->size(50)
                    ->toggleable(),

                TextColumn::make('title')
                    ->label('Başlık')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => $state ?? 'Kategori Yok'),

                TextColumn::make('desc')
                    ->label('İçerik')
                    ->limit(50)
                    ->wrap()
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
            'index'  => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit'   => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
