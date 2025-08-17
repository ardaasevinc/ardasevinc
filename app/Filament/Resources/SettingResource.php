<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationLabel = 'Genel Ayarlar';
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $pluralModelLabel = 'Genel Ayarlar';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Ayar';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Select::make('key')
                ->label('Ayar Anahtarı')
                ->options([
                    // Site Genel Ayarları
                    'APP_NAME' => 'Site Adı',
                    'APP_URL' => 'Site URL',
                    'SEO_TITLE' => 'SEO Başlığı',
                    'SEO_DESCRIPTION' => 'SEO Açıklaması',
                    'SEO_KEYWORDS' => 'SEO Anahtar Kelimeler',

                    // İletişim Bilgileri
                    'CONTACT_PHONE' => 'Telefon Numarası',
                    'CONTACT_EMAIL' => 'E-posta Adresi',
                    'CONTACT_ADDRESS' => 'Adres',
                    'CONTACT_WORKING_HOURS' => 'Çalışma Saatleri',
                    'CONTACT_GOOGLE_MAP_IFRAME' => 'Google Harita Embed Kodu',



                    //css js
                    'CUSTOM_CSS'=>'Özel css',
                    'CUSTOM_JS' =>'özel js',
                    // Sosyal Medya
                    'SOCIAL_FACEBOOK' => 'Facebook Sayfası',
                    'SOCIAL_INSTAGRAM' => 'Instagram Hesabı',
                    'SOCIAL_TWITTER' => 'Twitter (X) Hesabı',
                    'SOCIAL_YOUTUBE' => 'YouTube Kanalı',
                    'SOCIAL_LINKEDIN' => 'LinkedIn Hesabı',

                    // Google Entegrasyonları
                    'GOOGLE_ANALYTICS_ID' => 'Google Analytics Kimliği',
                    'GOOGLE_TAG_MANAGER_ID' => 'Google Tag Manager Kimliği',
                    'GOOGLE_RECAPTCHA_SITE_KEY' => 'Google reCAPTCHA Site Key',
                    'GOOGLE_RECAPTCHA_SECRET_KEY' => 'Google reCAPTCHA Secret Key',
                    'GOOGLE_MAPS_API_KEY' => 'Google Maps API Key',

                    // Facebook Entegrasyonu
                    'FACEBOOK_PIXEL_ID' => 'Facebook Pixel Kimliği',

                    // SMTP Mail Ayarları
                    'MAIL_MAILER' => 'Mail Sürücüsü (SMTP, Mailgun vs.)',
                    'MAIL_HOST' => 'Mail Sunucusu',
                    'MAIL_PORT' => 'Mail Portu',
                    'MAIL_USERNAME' => 'Mail Kullanıcı Adı',
                    'MAIL_PASSWORD' => 'Mail Şifresi',
                    'MAIL_ENCRYPTION' => 'Mail Şifreleme Türü (tls, ssl)',
                    'MAIL_FROM_ADDRESS' => 'Gönderici Mail Adresi',
                    'MAIL_FROM_NAME' => 'Gönderici Adı',

                    // Bakım Modu ve Kayıt Ayarları
                    'ENABLE_MAINTENANCE_MODE' => 'Bakım Modu Aktif mi? (true/false)',
                    'ALLOW_USER_REGISTRATION' => 'Kullanıcı Kaydı Açık mı? (true/false)',
                ])
                ->required()
                ->searchable()
                ->reactive()
                ->html()
                ->default('APP_NAME'),

            // RichEditor ile HTML destekli metin alanı
            RichEditor::make('value')
                ->label('Ayar Değeri')
                ->nullable()
                ->required()
                ->html()
                
                ->disableToolbarButtons(['strike', 'code', 'blockquote', 'link'])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('key')->label('Ayar Anahtarı')->sortable(),
            TextColumn::make('value')->label('Değer')->limit(50)->sortable(),
            TextColumn::make('updated_at')->label('Güncellenme Tarihi')->sortable(),
        ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    public static function afterSave($record)
    {
        if (!empty($record) && !empty($record->key)) {
            Setting::updateEnv($record->key, $record->value);
        }
    }
}
