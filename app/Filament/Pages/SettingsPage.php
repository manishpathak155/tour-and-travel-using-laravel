<?php

namespace App\Filament\Pages;

use App\Services\SettingService;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

/**
 * Manage global application settings.
 */
class SettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\UnitEnum|null $navigationGroup = 'System Settings';
    protected static ?string $navigationLabel = 'Settings';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $title = 'Settings';
    protected string $view = 'filament.pages.settings-page';

    public ?array $data = [];

    private const SETTING_KEYS = [
        'general.site_name',
        'general.tagline',
        'general.contact_email',
        'general.contact_phone',
        'general.whatsapp_number',
        'general.address',
        'general.tripadvisor_url',
        'general.tripadvisor_review_count',
        'general.google_maps_place_id',
        'general.google_review_count',
        'general.trustpilot_url',
        'general.trustpilot_review_count',
        'general.tawk_property_id',
        'general.tawk_widget_id',
        'general.facebook_url',
        'general.instagram_url',
        'general.youtube_url',
        'general.tiktok_url',
        'general.company_reg_number',
        'general.ntb_license_number',
        'booking.deposit_percentage',
        'booking.currency_default',
        'booking.tax_percentage',
        'booking.booking_terms',
        'booking.cancellation_policy_text',
        'seo.google_analytics_id',
        'seo.gtm_id',
        'seo.meta_description',
    ];

    public function mount(SettingService $settings): void
    {
        $this->form->fill($this->getInitialState($settings));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        Tabs\Tab::make('General')
                            ->schema([
                                Section::make('Site Identity')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('general.site_name')
                                                    ->label('Site name')
                                                    ->required()
                                                    ->maxLength(120),
                                                TextInput::make('general.tagline')
                                                    ->label('Tagline')
                                                    ->maxLength(160),
                                            ]),
                                        Textarea::make('general.address')
                                            ->label('Address')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Contact')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('general.contact_email')
                                                    ->label('Contact email')
                                                    ->email()
                                                    ->maxLength(120),
                                                TextInput::make('general.contact_phone')
                                                    ->label('Contact phone')
                                                    ->tel()
                                                    ->maxLength(40),
                                                TextInput::make('general.whatsapp_number')
                                                    ->label('WhatsApp number')
                                                    ->tel()
                                                    ->maxLength(40),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Social & Reviews')
                            ->schema([
                                Section::make('Social links')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('general.facebook_url')
                                                    ->label('Facebook URL')
                                                    ->url()
                                                    ->maxLength(255),
                                                TextInput::make('general.instagram_url')
                                                    ->label('Instagram URL')
                                                    ->url()
                                                    ->maxLength(255),
                                                TextInput::make('general.youtube_url')
                                                    ->label('YouTube URL')
                                                    ->url()
                                                    ->maxLength(255),
                                                TextInput::make('general.tiktok_url')
                                                    ->label('TikTok URL')
                                                    ->url()
                                                    ->maxLength(255),
                                            ]),
                                    ]),
                                Section::make('Review platforms')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('general.tripadvisor_url')
                                                    ->label('TripAdvisor URL')
                                                    ->url()
                                                    ->maxLength(500),
                                                TextInput::make('general.tripadvisor_review_count')
                                                    ->label('TripAdvisor review count')
                                                    ->numeric()
                                                    ->minValue(0),
                                                TextInput::make('general.google_maps_place_id')
                                                    ->label('Google Maps Place ID')
                                                    ->maxLength(255),
                                                TextInput::make('general.google_review_count')
                                                    ->label('Google review count')
                                                    ->numeric()
                                                    ->minValue(0),
                                                TextInput::make('general.trustpilot_url')
                                                    ->label('Trustpilot URL')
                                                    ->url()
                                                    ->maxLength(500),
                                                TextInput::make('general.trustpilot_review_count')
                                                    ->label('Trustpilot review count')
                                                    ->numeric()
                                                    ->minValue(0),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Live Chat')
                            ->schema([
                                Section::make('Tawk.to')
                                    ->description('Add the Tawk.to property and widget IDs to enable the live chat widget.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('general.tawk_property_id')
                                                    ->label('Property ID')
                                                    ->maxLength(120),
                                                TextInput::make('general.tawk_widget_id')
                                                    ->label('Widget ID')
                                                    ->maxLength(120),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Payment')
                            ->schema([
                                Section::make('Defaults')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Select::make('booking.currency_default')
                                                    ->label('Default currency')
                                                    ->options([
                                                        'USD' => 'USD',
                                                        'NPR' => 'NPR',
                                                        'EUR' => 'EUR',
                                                        'GBP' => 'GBP',
                                                    ])
                                                    ->searchable(),
                                                TextInput::make('booking.tax_percentage')
                                                    ->label('Tax percentage')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->suffix('%'),
                                                TextInput::make('booking.deposit_percentage')
                                                    ->label('Deposit percentage')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->suffix('%'),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Booking Policy')
                            ->schema([
                                Section::make('Terms')
                                    ->schema([
                                        RichEditor::make('booking.booking_terms')
                                            ->label('Booking terms')
                                            ->columnSpanFull(),
                                        RichEditor::make('booking.cancellation_policy_text')
                                            ->label('Cancellation policy')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Section::make('Analytics')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('seo.google_analytics_id')
                                                    ->label('Google Analytics ID (GA4)')
                                                    ->maxLength(50),
                                                TextInput::make('seo.gtm_id')
                                                    ->label('Google Tag Manager ID')
                                                    ->maxLength(50),
                                            ]),
                                        Textarea::make('seo.meta_description')
                                            ->label('Default meta description')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Company')
                            ->schema([
                                Section::make('Registration')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('general.company_reg_number')
                                                    ->label('Company registration number')
                                                    ->maxLength(120),
                                                TextInput::make('general.ntb_license_number')
                                                    ->label('NTB license number')
                                                    ->maxLength(120),
                                            ]),
                                    ]),
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
