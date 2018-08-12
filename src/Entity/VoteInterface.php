<?php

namespace App\Entity;

interface VoteInterface
{
    const VALUE_UP   = 1;
    const VALUE_DOWN = -1;

    public function getValue(): ?int;

    public function setValue(int $value);

    public function getUser(): ?User;

    public function setUser(?User $user);
}