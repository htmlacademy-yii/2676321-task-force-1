<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Task;
use App\Actions\StartAction;
use App\Actions\CancelAction;
use App\Actions\CompleteAction;
use App\Actions\FailAction;
use App\Actions\RespondAction;

class TaskTest extends TestCase
{
    public function testNewTaskActionsForAuthor(): void
    {
        $task = new Task(authorId: 1);

        $actions = $task->getAllowedActions(1);

        $this->assertCount(2, $actions);

        $this->assertInstanceOf(StartAction::class, $actions[0]);
        $this->assertInstanceOf(CancelAction::class, $actions[1]);
    }

    public function testNewTaskActionsForOtherUser(): void
    {
        $task = new Task(authorId: 1);

        $actions = $task->getAllowedActions(2);

        $this->assertCount(1, $actions);
        $this->assertInstanceOf(RespondAction::class, $actions[0]);
    }

    public function testActiveTaskActionsForExecutor(): void
    {
        $task = new Task(
            authorId: 1,
            status: Task::STATUS_ACTIVE,
            executorId: 2
        );

        $actions = $task->getAllowedActions(2);

        $this->assertCount(1, $actions);
        $this->assertContainsOnlyInstancesOf(FailAction::class, $actions);
    }

    public function testNextStatusFromNewToActive(): void
    {
        $task = new Task(authorId: 1);

        $this->assertSame(
            Task::STATUS_ACTIVE,
            $task->getNextStatus(new StartAction())
        );
    }

    public function testNextStatusFromNewToCanceled(): void
    {
        $task = new Task(authorId: 1);

        $this->assertSame(
            Task::STATUS_CANCELED,
            $task->getNextStatus(new CancelAction())
        );
    }

    public function testNextStatusFromActiveToCompleted(): void
    {
        $task = new Task(
            authorId: 1,
            status: Task::STATUS_ACTIVE
        );

        $this->assertSame(
            Task::STATUS_COMPLETED,
            $task->getNextStatus(new CompleteAction())
        );
    }

    public function testInvalidActionReturnsNull(): void
    {
        $task = new Task(authorId: 1);

        $this->assertNull(
            $task->getNextStatus(new CompleteAction())
        );
    }
}
