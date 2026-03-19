<?php

namespace App\Actions;

class CompleteAction extends Action
{
    public function getName(): string
    {
        return 'Завершить';
    }

    public function getActionCode(): string
    {
        return 'complete';
    }

    public function isAllowed(int $userId, int $authorId, ?int $executorId): bool
    {
        return $userId === $authorId;
    }
}
