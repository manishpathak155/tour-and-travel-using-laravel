<?php

namespace App\Filament\Resources\Coupons\Pages;

use App\Filament\Resources\Coupons\CouponResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Create a coupon.
 */
class CreateCoupon extends CreateRecord
{
    protected static string $resource = CouponResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
