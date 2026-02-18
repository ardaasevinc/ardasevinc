<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    
    protected static ?string $navigationLabel = 'Gelen Mesajlar';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $pluralModelLabel = 'İletişim Mesajları';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Mesaj';

    // Global Search: Gönderen adı veya e-posta üzerinden arama
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Mesaj Detayları')
                    ->description('Gelen form mesajının içeriğini inceleyin.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Ad Soyad')
                            ->disabled() // Gelen mesaj düzenlenmemeli, sadece okunmalı
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('E-posta')
                            ->email()
                            ->disabled()
                            ->maxLength(255),

                        Textarea::make('message')
                            ->label('Mesaj İçeriği')
                            ->disabled()
                            ->rows(5)
                            ->columnSpanFull(),

                        Toggle::make('is_read')
                            ->label('Okundu Olarak İşaretle')
                            ->default(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                IconColumn::make('is_read')
                    ->label('Durum')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Ad Soyad')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('E-posta')
                    ->sortable()
                    ->searchable()
                    ->copyable() // Tek tıkla e-postayı kopyalamak için
                    ->copyMessage('E-posta kopyalandı'),

                TextColumn::make('message')
                    ->label('Mesaj Özeti')
                    ->limit(40)
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // En yeni mesaj en üstte
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Okunma Durumu')
                    ->placeholder('Tümü')
                    ->trueLabel('Okunanlar')
                    ->falseLabel('Okunmayanlar'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Toplu olarak okundu işaretleme özelliği
                    Tables\Actions\BulkAction::make('markAsRead')
                        ->label('Okundu İşaretle')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_read' => true])),
                ]),
            ])
            ->emptyStateHeading('Mesaj Kutusu Boş')
            ->emptyStateDescription('Henüz iletişim formundan bir mesaj almadınız.');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'message'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}