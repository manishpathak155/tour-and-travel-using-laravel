<?php

namespace App\Filament\Resources\TeamMembers\Pages;

use App\Filament\Resources\TeamMembers\TeamMemberResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Create a team member.
 */
class CreateTeamMember extends CreateRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
