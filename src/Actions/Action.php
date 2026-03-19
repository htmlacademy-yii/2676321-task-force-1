<?php

namespace App\Actions;

abstract class Action
{
    abstract public function getName(): string;
    abstract public function getActionCode(): string;
    abstract public function isAllowed(int $userId, int $authorId, ?int $executorId): bool;
}
