<?php

namespace App\Support;

/**
 * Centralized destination location options.
 */
class DestinationLocationOptions
{
    /**
     * Get Asian country options.
     *
     * @return array<string, string>
     */
    public static function countries(): array
    {
        return array_combine(self::asianCountries(), self::asianCountries());
    }

    /**
     * Get Nepal zone options.
     *
     * @return array<string, string>
     */
    public static function zones(): array
    {
        return array_combine(self::nepalZones(), self::nepalZones());
    }

    /**
     * Get Nepal district options for a zone.
     *
     * @param  string|null  $zone
     * @return array<string, string>
     */
    public static function districts(?string $zone = null): array
    {
        $districtsByZone = self::districtsByZone();

        if (! $zone || ! isset($districtsByZone[$zone])) {
            return [];
        }

        return array_combine($districtsByZone[$zone], $districtsByZone[$zone]);
    }

    /**
     * Get all supported Asian countries.
     *
     * @return array<int, string>
     */
    private static function asianCountries(): array
    {
        return [
            'Afghanistan',
            'Armenia',
            'Azerbaijan',
            'Bahrain',
            'Bangladesh',
            'Bhutan',
            'Brunei',
            'Cambodia',
            'China',
            'Cyprus',
            'Georgia',
            'India',
            'Indonesia',
            'Iran',
            'Iraq',
            'Israel',
            'Japan',
            'Jordan',
            'Kazakhstan',
            'Kuwait',
            'Kyrgyzstan',
            'Laos',
            'Lebanon',
            'Malaysia',
            'Maldives',
            'Mongolia',
            'Myanmar',
            'Nepal',
            'North Korea',
            'Oman',
            'Pakistan',
            'Palestine',
            'Philippines',
            'Qatar',
            'Russia',
            'Saudi Arabia',
            'Singapore',
            'South Korea',
            'Sri Lanka',
            'Syria',
            'Taiwan',
            'Tajikistan',
            'Thailand',
            'Timor-Leste',
            'Turkey',
            'Turkmenistan',
            'United Arab Emirates',
            'Uzbekistan',
            'Vietnam',
            'Yemen',
        ];
    }

    /**
     * Get Nepal zone names.
     *
     * @return array<int, string>
     */
    private static function nepalZones(): array
    {
        return [
            'Mechi',
            'Koshi',
            'Sagarmatha',
            'Janakpur',
            'Bagmati',
            'Narayani',
            'Gandaki',
            'Dhaulagiri',
            'Lumbini',
            'Rapti',
            'Bheri',
            'Karnali',
            'Seti',
            'Mahakali',
        ];
    }

    /**
     * Get districts grouped by Nepal zone.
     *
     * @return array<string, array<int, string>>
     */
    private static function districtsByZone(): array
    {
        return [
            'Mechi' => ['Ilam', 'Jhapa', 'Panchthar', 'Taplejung'],
            'Koshi' => ['Bhojpur', 'Dhankuta', 'Morang', 'Sankhuwasabha', 'Sunsari', 'Terhathum'],
            'Sagarmatha' => ['Khotang', 'Okhaldhunga', 'Saptari', 'Siraha', 'Solukhumbu', 'Udayapur'],
            'Janakpur' => ['Dhanusha', 'Dolakha', 'Mahottari', 'Ramechhap', 'Sarlahi', 'Sindhuli'],
            'Bagmati' => ['Bhaktapur', 'Dhading', 'Kathmandu', 'Kavrepalanchok', 'Lalitpur', 'Nuwakot', 'Rasuwa', 'Sindhupalchok'],
            'Narayani' => ['Bara', 'Chitwan', 'Makwanpur', 'Parsa', 'Rautahat'],
            'Gandaki' => ['Gorkha', 'Kaski', 'Lamjung', 'Manang', 'Syangja', 'Tanahun'],
            'Dhaulagiri' => ['Baglung', 'Mustang', 'Myagdi', 'Parbat'],
            'Lumbini' => ['Arghakhanchi', 'Gulmi', 'Kapilvastu', 'Nawalparasi', 'Palpa', 'Rupandehi'],
            'Rapti' => ['Dang', 'Pyuthan', 'Rolpa', 'Rukum', 'Salyan'],
            'Bheri' => ['Banke', 'Bardiya', 'Dailekh', 'Jajarkot', 'Surkhet'],
            'Karnali' => ['Dolpa', 'Humla', 'Jumla', 'Kalikot', 'Mugu'],
            'Seti' => ['Achham', 'Bajhang', 'Bajura', 'Doti'],
            'Mahakali' => ['Baitadi', 'Dadeldhura', 'Darchula', 'Kanchanpur'],
        ];
    }
}