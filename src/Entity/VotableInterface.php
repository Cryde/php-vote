<?php

namespace App\Entity;

interface VotableInterface
{
    public function getTotalVoteUp(): ?int;

    public function getTotalVoteDown(): ?int;

    public function setTotalVoteUp(int $totalVoteUp);

    public function setTotalVoteDown(int $totalVoteDown);

    public function removeVote($vote);
}