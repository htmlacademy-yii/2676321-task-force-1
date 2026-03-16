<?php

namespace App;

/**
 * Класс Задание.
 * Описывает задачу, ее статус и возможные действия
 */
class Task
{
    public const string STATUS_NEW = 'new';
    public const string STATUS_CANCELED = 'canceled';
    public const string STATUS_ACTIVE = 'active';
    public const string STATUS_COMPLETED = 'completed';
    public const string STATUS_FAILED = 'failed';


    public const string ACTION_RESPOND = 'respond';
    public const string ACTION_CANCEL = 'cancel';
    public const string ACTION_START = 'start';
    public const string ACTION_COMPLETE = 'complete';
    public const string ACTION_FAIL = 'fail';

    /**
     * Список допустимых действий в зависимости от статуса.
     */
    private const array ACTIONS_BY_STATUS = [
        self::STATUS_NEW => [
            self::ACTION_RESPOND,
            self::ACTION_START,
            self::ACTION_CANCEL,
        ],
        self::STATUS_ACTIVE => [
            self::ACTION_COMPLETE,
            self::ACTION_FAIL,
        ],
    ];

    /**
     * Таблица переходов состояния задачи.
     */
    private const array STATE_TRANSITIONS = [
        self::STATUS_NEW => [
            self::ACTION_START => self::STATUS_ACTIVE,
            self::ACTION_CANCEL => self::STATUS_CANCELED,
        ],
        self::STATUS_ACTIVE => [
            self::ACTION_COMPLETE => self::STATUS_COMPLETED,
            self::ACTION_FAIL => self::STATUS_FAILED,
        ],
    ];

    private string $status;
    private int $authorId;
    private ?int $executorId;


    public function __construct(int $authorId, string $status = self::STATUS_NEW, ?int $executorId = null)
    {
        $this->status = $status;
        $this->authorId = $authorId;
        $this->executorId = $executorId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getExecutorId(): ?int
    {
        return $this->executorId;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * Возвращает список всех возможных статусов задачи.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_ACTIVE => 'В работе',
            self::STATUS_COMPLETED => 'Выполнено',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_FAILED => 'Провалено'
        ];
    }

    /**
     * Возвращает список всех возможных действий.
     *
     * @return array
     */
    public static function getActions(): array
    {
        return [
            self::ACTION_START => 'Принять',
            self::ACTION_COMPLETE => 'Завершить',
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_FAIL => 'Отказаться',
            self::ACTION_RESPOND => 'Откликнуться',
        ];
    }

    /**
     * Возвращает статус задачи после выполнения данного действия.
     *
     * @param string $action
     * @return string|null Следующий статус или null, если действие недопустимо
     */
    public function getNextStatus(string $action): ?string
    {
        return self::STATE_TRANSITIONS[$this->status][$action] ?? null;
    }

    /**
     * Возвращает список допустимых действий для данного статуса.
     *
     * @param string $status
     * @return array Список действий или пустой массив, если доступных действий нет
     */
    public static function getAllowedActions(string $status): array
    {
        return self::ACTIONS_BY_STATUS[$status] ?? [];
    }
}
