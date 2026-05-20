<?php

namespace App\Filament\Resources\Coupons\Pages;

use App\Filament\Resources\Coupons\CouponResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit a coupon.
 */
class EditCoupon extends EditRecord
{
    protected static string $resource = CouponResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
