<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogCategoryResource\Pages;
use App\Models\BlogCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;
    protected static ?string $navigationLabel = 'Blog Kategorileri';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralModelLabel = 'Blog Kategorileri';
    protected static ?string $navigationGroup = 'Haber Yönetimi';
    protected static ?string $modelLabel = 'Blog Kategorisi';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Kategori Bilgileri')
                    ->schema([
                        TextInput::make('name')
                            ->label('Kategori Adı')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, $state) {
                                if (!filled($set('slug'))) {
                                    $set('slug', Str::slug((string) $state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->helperText('Kategori adından otomatik oluşur, istersen düzenleyebilirsin.')
                            ->rule('alpha_dash')
                            ->unique(table: BlogCategory::class, column: 'slug', ignorable: fn($record) => $record)
                            ->dehydrateStateUsing(fn($state) => Str::slug((string) $state))
                            ->nullable(),

                        Toggle::make('is_published')
                            ->label('Yayın Durumu')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Kategori Adı')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->label('Slug')
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }
}
