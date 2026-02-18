<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscribeResource\Pages;
use App\Models\Subscribe;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class SubscribeResource extends Resource
{
    protected static ?string $model = Subscribe::class;

    protected static ?string $navigationLabel = 'E-Bülten Aboneleri';
    protected static ?string $navigationIcon = 'heroicon-o-envelope-open'; // Daha spesifik bir ikon
    protected static ?string $pluralModelLabel = 'E-Bülten Aboneleri';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Abone';

    // Global Search: E-posta üzerinden hızlı arama [Image of Laravel Filament global search functionality]
    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Section::make('Abonelik Bilgileri')
                ->schema([
                    TextInput::make('email')
                        ->label('E-Posta Adresi')
                        ->required()
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->placeholder('ornek@domain.com'),
                ]),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('E-Posta Adresi')
                    ->sortable()
                    ->searchable()
                    ->copyable() // E-postayı tek tıkla kopyalamak için
                    ->copyMessage('E-posta kopyalandı'),

                TextColumn::make('created_at')
                    ->label('Abonelik Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // En son abone olan en üstte
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Başlangıç'),
                        Forms\Components\DatePicker::make('created_until')->label('Bitiş'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn ($query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn ($query, $date) => $query->whereDate('created_at', '<=', $date));
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Buraya ileride toplu mail gönderme veya excel aktarma eklenebilir
                ]),
            ])
            ->emptyStateHeading('Henüz bir abone yok.')
            ->emptyStateDescription('E-bülten formunu dolduranlar burada listelenecek.');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['email'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscribes::route('/'),
        ];
    }
}