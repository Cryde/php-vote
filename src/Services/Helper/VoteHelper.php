<?php

namespace App\Services\Helper;

use App\Entity\Vote;

class VoteHelper
{
    /**
     * @param Vote[] $votes
     *
     * @return array
     */
    public function toArrayWithIdeaIdAsKey($votes)
    {
        $result = [];
        foreach ($votes as $vote) {
            $result[$vote->getIdea()->getId()] = $vote;
        }

        return $result;
    }
}