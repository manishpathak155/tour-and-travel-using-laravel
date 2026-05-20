<?php

namespace App\Filament\Resources\TeamMembers\Pages;

use App\Filament\Resources\TeamMembers\TeamMemberResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit a team member.
 */
class EditTeamMember extends EditRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
