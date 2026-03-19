<?php

namespace App\Actions;

class RespondAction extends Action
{
    public function getName(): string
    {
        return 'Откликнуться';
    }

    public function getActionCode(): string
    {
        return 'respond';
    }

    public function isAllowed(int $userId, int $authorId, ?int $executorId): bool
    {
        return $executorId === null && $userId !== $authorId;
    }
}
