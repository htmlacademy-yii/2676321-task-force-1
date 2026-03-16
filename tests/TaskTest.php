<?php

require_once __DIR__ . '/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use App\Task;

class TaskTest extends TestCase
{
    public function testDefaultStatusIsNew(): void
    {
        $task = new Task(authorId: 1);

        $this->assertSame(Task::STATUS_NEW, $task->getStatus());
        $this->assertSame(1, $task->getAuthorId());
        $this->assertNull($task->getExecutorId());
    }

    public function testConstructorSetsStatus(): void
    {
        $task = new Task(
            authorId: 1,
            status: Task::STATUS_ACTIVE
        );

        $this->assertSame(Task::STATUS_ACTIVE, $task->getStatus());
    }

    public function testConstructorSetsExecutorId(): void
    {
        $task = new Task(
            authorId: 1,
            status: Task::STATUS_NEW,
            executorId: 13
        );

        $this->assertSame(13, $task->getExecutorId());
    }

    public function testGetNextStatusFromNew(): void
    {
        $task = new Task(authorId: 1);

        $this->assertSame(
            Task::STATUS_ACTIVE,
            $task->getNextStatus(Task::ACTION_START)
        );

        $this->assertSame(
            Task::STATUS_CANCELED,
            $task->getNextStatus(Task::ACTION_CANCEL)
        );
    }

    public function testGetNextStatusFromActive(): void
    {
        $task = new Task(
            authorId: 1,
            status: Task::STATUS_ACTIVE
        );

        $this->assertSame(
            Task::STATUS_COMPLETED,
            $task->getNextStatus(Task::ACTION_COMPLETE)
        );

        $this->assertSame(
            Task::STATUS_FAILED,
            $task->getNextStatus(Task::ACTION_FAIL)
        );
    }

    public function testInvalidActionReturnsNull(): void
    {
        $task = new Task(authorId: 1);

        $this->assertNull($task->getNextStatus(Task::ACTION_COMPLETE));
    }

    public function testGetAllowedActionsForNew(): void
    {
        $actions = Task::getAllowedActions(Task::STATUS_NEW);

        $this->assertCount(3, $actions);
        $this->assertContains(Task::ACTION_START, $actions);
        $this->assertContains(Task::ACTION_CANCEL, $actions);
        $this->assertContains(Task::ACTION_RESPOND, $actions);
    }

    public function testGetAllowedActionsForActive(): void
    {
        $actions = Task::getAllowedActions(Task::STATUS_ACTIVE);

        $this->assertCount(2, $actions);
        $this->assertContains(Task::ACTION_COMPLETE, $actions);
        $this->assertContains(Task::ACTION_FAIL, $actions);
    }

    public function testGetAllowedActionsForUnknownStatus(): void
    {
        $actions = Task::getAllowedActions('unknown');

        $this->assertSame([], $actions);
    }

    public function testGetStatuses(): void
    {
        $statuses = Task::getStatuses();

        $this->assertCount(5, $statuses);
        $this->assertArrayHasKey(Task::STATUS_NEW, $statuses);
        $this->assertArrayHasKey(Task::STATUS_ACTIVE, $statuses);
        $this->assertArrayHasKey(Task::STATUS_COMPLETED, $statuses);
        $this->assertArrayHasKey(Task::STATUS_CANCELED, $statuses);
        $this->assertArrayHasKey(Task::STATUS_FAILED, $statuses);
    }

    public function testGetActions(): void
    {
        $actions = Task::getActions();

        $this->assertCount(5, $actions);

        $this->assertArrayHasKey(Task::ACTION_START, $actions);
        $this->assertArrayHasKey(Task::ACTION_CANCEL, $actions);
        $this->assertArrayHasKey(Task::ACTION_RESPOND, $actions);
        $this->assertArrayHasKey(Task::ACTION_COMPLETE, $actions);
        $this->assertArrayHasKey(Task::ACTION_FAIL, $actions);
    }
}
