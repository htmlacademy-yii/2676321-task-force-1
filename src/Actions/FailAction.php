<?php

namespace App\Actions;

class FailAction extends Action
{
    public function getName(): string
    {
        return 'Отказаться';
    }

    public function getActionCode(): string
    {
        return 'fail';
    }

    public function isAllowed(int $userId, int $authorId, ?int $executorId): bool
    {
        return $executorId !== null && $userId === $executorId;
    }
}
