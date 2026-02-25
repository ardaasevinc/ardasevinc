<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Cache;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Sistem Ayarları';
    protected static ?string $navigationGroup = 'Site Yönetimi';
    protected static ?string $modelLabel = 'Genel Ayar';
    protected static ?string $pluralModelLabel = 'Sistem Ayarları';

    // Sadece 1 adet ayar kaydı olmasını garantiye alalım
    public static function canCreate(): bool
    {
        return Setting::count() < 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs([
                        // 1. SEKME: KURUMSAL & İLETİŞİM
                        Tabs\Tab::make('Kurumsal & İletişim')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Grid::make(12)->schema([
                                    Section::make('Marka Kimliği')->columnSpan(4)->schema([
                                        TextInput::make('site_name')->label('Site Adı'),
                                        TextInput::make('slogan')->label('Slogan'),
                                        FileUpload::make('logo_light')->label('Logo (Açık Zemin)')->disk('uploads')->directory('settings')->image()->toWebp(),
                                        FileUpload::make('logo_dark')->label('Logo (Koyu Zemin)')->disk('uploads')->directory('settings')->image()->toWebp(),
                                        FileUpload::make('favicon')->label('Favicon')->disk('uploads')->directory('settings')->image()->toWebp(),
                                        FileUpload::make('og_image')->label('Sosyal Medya Paylaşım Görseli (OG)')->disk('uploads')->directory('settings')->image()->toWebp(),
                                    ]),
                                    Section::make('İletişim Bilgileri')->columnSpan(8)->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('email')->email()->label('E-Posta Adresi'),
                                            TextInput::make('phone')->label('Telefon')->helperText('905326379944 şeklinde telefon numarası giriniz.'),
                                           
                                            TextInput::make('whatsapp')->label('WhatsApp Numarası')->placeholder('905xxxxxxxxx')->helperText('Bu telefon numarası whatsapp aramaları için kullanılacaktır.'),
                                        ]),
                                        Textarea::make('address')->label('Adres Bilgisi')->rows(3),
                                        RichEditor::make('work_time')->label('Çalışma Saatleri'),
                                        Grid::make(2)->schema([
                                            Textarea::make('map_iframe')->label('Google Maps Iframe Kodu')->columnSpanFull(),
                                            TextInput::make('map_link')->label('Harita Linki (Navigasyon)')->columnSpanFull(),
                                        ]),
                                    ]),
                                ]),
                            ]),

                        // 2. SEKME: SEO & SOSYAL MEDYA
                        Tabs\Tab::make('SEO & Sosyal Medya')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Grid::make(12)->schema([
                                    Section::make('Meta Verileri (SEO)')->columnSpan(6)->schema([
                                        TextInput::make('meta_title')->label('SEO Başlığı'),
                                        Textarea::make('meta_desc')->label('SEO Açıklaması')->rows(4),
                                        TextInput::make('meta_keywords')->label('Anahtar Kelimeler'),
                                    ]),
                                    Section::make('Sosyal Medya Profilleri')->columnSpan(6)->schema([
                                        TextInput::make('twitter_url')->label('X / Twitter URL')->url(),
                                        TextInput::make('linkedin_url')->label('LinkedIn URL')->url(),
                                        TextInput::make('youtube_url')->label('YouTube URL')->url(),
                                        TextInput::make('instagram_access_token')->label('Instagram URL'),
                                    ]),
                                ]),
                            ]),

                        // 3. SEKME: ANALİZ & ÖZEL KODLAR
                        Tabs\Tab::make('İzleme & Scriptler')
                            ->icon('heroicon-o-code-bracket')
                            ->schema([
                                Section::make('Takip Kodları')
                                    ->description('Google Analytics ve Pixel gibi araçların ID bilgilerini buraya girin.')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('google_analytics_code')->label('Google Analytics ID')->placeholder('G-XXXXXXXXXX'),
                                            TextInput::make('facebook_pixel_code')->label('Facebook Pixel ID')->placeholder('123456789'),
                                        ]),
                                    ]),
                                Section::make('Özel Kod Alanları')
                                    ->description('Canlı destek, CSS veya JS kodlarını güvenli bir şekilde ekleyin.')
                                    ->schema([
                                        Textarea::make('header_scripts')->label('Header Scriptleri (<head> içi)')->rows(5),
                                        Textarea::make('body_scripts')->label('Body Scriptleri (<body> başlangıcı)')->rows(5),
                                        Textarea::make('footer_scripts')->label('Footer Scriptleri (</body> sonu)')->rows(5),
                                    ]),
                            ]),

                        // 4. SEKME: SİSTEM & MAİL AYARLARI
                        Tabs\Tab::make('Sistem & SMTP')
                            ->icon('heroicon-o-server')
                            ->schema([
                                Grid::make(12)->schema([
                                    Section::make('Uygulama Ayarları')->columnSpan(4)->schema([
                                        TextInput::make('app_url')->label('App URL'),
                                        Select::make('app_env')
                                            ->label('App Environment')
                                            ->options([
                                                'local' => 'Local',
                                                'production' => 'Production'
                                            ])
                                            ->default('local'),
                                        Toggle::make('maintenance_mode')->label('Bakım Modu')->onColor('danger'),
                                        Toggle::make('app_debug')->label('Debug Modu')->default(true),
                                    ]),
                                    Section::make('SMTP Mail Sunucusu')->columnSpan(8)->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('mail_mailer')->label('Mail Mailer')->default('smtp'),
                                            TextInput::make('mail_host')->label('Mail Host'),
                                            TextInput::make('mail_port')->label('Mail Port'),
                                            TextInput::make('mail_username')->label('Kullanıcı Adı'),
                                            TextInput::make('mail_password')->label('Şifre')->password()->revealable(),
                                            TextInput::make('mail_encryption')->label('Şifreleme (tls/ssl)'),
                                            TextInput::make('mail_from_address')->label('Gönderen E-Posta'),
                                            TextInput::make('mail_from_name')->label('Gönderen Adı'),
                                        ]),
                                    ]),
                                ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_name')->label('Site Adı')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('İletişim E-Posta'),
                Tables\Columns\IconColumn::make('maintenance_mode')->label('Bakım Modu')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->label('Son Güncelleme')->dateTime('d.m.Y H:i'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(fn () => Cache::forget('site.settings')), // Güncelleme sonrası önbelleği temizler
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
}