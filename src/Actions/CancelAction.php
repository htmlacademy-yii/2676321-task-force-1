<?php

namespace App\Actions;

class CancelAction extends Action
{
    public function getName(): string
    {
        return 'Отменить';
    }

    public function getActionCode(): string
    {
        return 'cancel';
    }

    public function isAllowed(int $userId, int $authorId, ?int $executorId): bool
    {
        return $userId === $authorId;
    }
}
