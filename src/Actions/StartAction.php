<?php

namespace App\Actions;

class StartAction extends Action
{
    public function getName(): string
    {
        return 'Принять';
    }

    public function getActionCode(): string
    {
        return 'start';
    }

    public function isAllowed(int $userId, int $authorId, ?int $executorId): bool
    {
        return $userId === $authorId;
    }
}
