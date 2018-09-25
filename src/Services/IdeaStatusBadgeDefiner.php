<?php

namespace App\Services;

use App\Entity\IdeaStatus;

class IdeaStatusBadgeDefiner
{
    /**
     * @param IdeaStatus $ideaStatus
     *
     * @return string
     */
    public function getBadgeLevel(IdeaStatus $ideaStatus): string
    {
        switch ($ideaStatus->getSlug()) {

            case 'implemented' :
                return 'success';
            case 'closed':
                return 'dark';
            case 'need-example':
            case 'need-author':
                return 'warning';
            case 'troll':
                return 'info';
            default:
                return 'primary';
        }
    }
}