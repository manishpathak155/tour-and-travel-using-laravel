<?php

namespace App\Filament\Pages;

use App\Services\SettingService;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;
    protected static string|\UnitEnum|null $navigationGroup = 'System Settings';
    protected static ?string $navigationLabel = 'Site Settings';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $title = 'Altivaro Settings';
    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    private const SETTING_KEYS = [
        'site_name',
        'site_slogan',
        'site_tagline',
        'site_description',
        'brand_logo',
        'brand_logo_dark',
        'site_favicon',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'seo_og_image',
        'contact_email',
        'contact_phone',
        'contact_whatsapp',
        'contact_address',
        'contact_city',
        'contact_country',
        'contact_map_embed',
        'social_facebook',
        'social_instagram',
        'social_x',
        'social_youtube',
        'social_tiktok',
        'social_linkedin',
        'social_tripadvisor',
        'admin_primary_color',
        'admin_secondary_color',
        'admin_accent_color',
        'admin_sidebar_color',
    ];

    public function mount(SettingService $settings): void
    {
        $this->form->fill($this->getInitialState($settings));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Branding')
                    ->description('Logo, slogan, and public-facing identity.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Site name')
                                    ->required()
                                    ->maxLength(120),
                                TextInput::make('site_slogan')
                                    ->label('Slogan')
                                    ->maxLength(160),
                                TextInput::make('site_tagline')
                                    ->label('Tagline')
                                    ->maxLength(160),
                                Textarea::make('site_description')
                                    ->label('Short description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                FileUpload::make('brand_logo')
                                    ->label('Primary logo')
                                    ->image()
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth(1600)
                                    ->imageResizeTargetHeight(1600)
                                    ->imageResizeUpscale(false)
                                    ->disk('public')
                                    ->directory('settings/branding')
                                    ->visibility('public')
                                    ->maxSize(2048),
                                FileUpload::make('brand_logo_dark')
                                    ->label('Dark logo')
                                    ->image()
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth(1600)
                                    ->imageResizeTargetHeight(1600)
                                    ->imageResizeUpscale(false)
                                    ->disk('public')
                                    ->directory('settings/branding')
                                    ->visibility('public')
                                    ->maxSize(2048),
                                FileUpload::make('site_favicon')
                                    ->label('Favicon')
                                    ->image()
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth(512)
                                    ->imageResizeTargetHeight(512)
                                    ->imageResizeUpscale(false)
                                    ->disk('public')
                                    ->directory('settings/branding')
                                    ->visibility('public')
                                    ->maxSize(1024),
                            ]),
                    ]),
                Section::make('Admin Appearance')
                    ->description('Color palette for the admin panel.')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                ColorPicker::make('admin_primary_color')
                                    ->label('Primary')
                                    ->hex(),
                                ColorPicker::make('admin_secondary_color')
                                    ->label('Secondary')
                                    ->hex(),
                                ColorPicker::make('admin_accent_color')
                                    ->label('Accent')
                                    ->hex(),
                                ColorPicker::make('admin_sidebar_color')
                                    ->label('Sidebar')
                                    ->hex(),
                            ]),
                    ]),
                Section::make('Contact Details')
                    ->description('Public contact details shown on the site.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('contact_email')
                                    ->label('Contact email')
                                    ->email()
                                    ->maxLength(120),
                                TextInput::make('contact_phone')
                                    ->label('Phone')
                                    ->tel()
                                    ->maxLength(40),
                                TextInput::make('contact_whatsapp')
                                    ->label('WhatsApp')
                                    ->tel()
                                    ->maxLength(40),
                                TextInput::make('contact_city')
                                    ->label('City')
                                    ->maxLength(80),
                                TextInput::make('contact_country')
                                    ->label('Country')
                                    ->maxLength(80),
                                Textarea::make('contact_address')
                                    ->label('Address')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Textarea::make('contact_map_embed')
                                    ->label('Map embed code')
                                    ->helperText('Paste the iframe embed code or a map URL.')
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ]),
                    ]),
                Section::make('Social Media')
                    ->description('Links to social profiles.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('social_facebook')
                                    ->label('Facebook')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('social_instagram')
                                    ->label('Instagram')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('social_x')
                                    ->label('X (Twitter)')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('social_youtube')
                                    ->label('YouTube')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('social_tiktok')
                                    ->label('TikTok')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('social_linkedin')
                                    ->label('LinkedIn')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('social_tripadvisor')
                                    ->label('Tripadvisor')
                                    ->url()
                                    ->maxLength(255),
                            ]),
                    ]),
                Section::make('SEO')
                    ->description('Metadata and sharing previews.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('seo_title')
                                    ->label('Meta title')
                                    ->maxLength(120),
                                TextInput::make('seo_keywords')
                                    ->label('Meta keywords')
                                    ->maxLength(255),
                                Textarea::make('seo_description')
                                    ->label('Meta description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                FileUpload::make('seo_og_image')
                                    ->label('Open Graph image')
                                    ->image()
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth(2400)
                                    ->imageResizeTargetHeight(1260)
                                    ->imageResizeUpscale(false)
                                    ->disk('public')
                                    ->directory('settings/seo')
                                    ->visibility('public')
                                    ->maxSize(2048)
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(SettingService $settings): void
    {
        $data = $this->form->getState();

        foreach (self::SETTING_KEYS as $key) {
            $settings->set($key, $data[$key] ?? null);
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }

    private function getInitialState(SettingService $settings): array
    {
        $state = [];

        foreach (self::SETTING_KEYS as $key) {
            $state[$key] = $settings->get($key);
        }

        return $state;
    }
}
