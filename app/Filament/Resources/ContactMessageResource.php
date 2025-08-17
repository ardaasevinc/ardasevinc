<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    
    protected static ?string $navigationLabel = 'İletişim Formu';
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $pluralModelLabel = 'İletşim Formu Mesajları';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Form';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Ad Soyad')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('E-posta')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Textarea::make('message')
                    ->label('Mesaj')
                    ->required()
                    ->maxLength(500),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Ad Soyad')->sortable(),
                Tables\Columns\TextColumn::make('email')->label('E-posta')->sortable(),
                Tables\Columns\TextColumn::make('message')->label('Mesaj')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Gönderim Tarihi')->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
