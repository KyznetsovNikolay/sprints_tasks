<?php

declare(strict_types=1);

namespace App\Controller;

use App\Module\Task\Repository\TaskRepository;
use App\Module\Task\UseCase\Add\Command as CreateCommand;
use App\Module\Task\UseCase\Close\Command as CloseCommand;
use App\Module\Task\UseCase\Add\Handler as CreateHandler;
use App\Module\Task\UseCase\Close\Handler as CloseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/tasks")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("", name="create_task", methods={"POST"})
     * Request:
     * {
     *    "sprintId": "18-12",
     *    "estimation": "d1",
     *    "title": "some title",
     *    "description": "some description"
     * }
     *
     * Response:
     * {
     *    "id": "TASK-1"
     * }
     */
    public function create(Request $request, CreateHandler $handler): JsonResponse
    {
        try {
            $params = json_decode($request->getContent(), true);
            $sprintId = $params['sprintId'] ?? '';
            $estimation = $params['estimation'] ?? '';
            $title = $params['title'] ?? '';
            $description = $params['description'] ?? '';
            $command = new CreateCommand($sprintId, $estimation, $title, $description);
            $task = $handler->handle($command);
            return new JsonResponse(['success' => "TASK-{$task->getId()}"]);

        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }
    }

    /**
     * @Route("/close", name="close_task", methods={"POST"})
     * {
     *    "taskId": "TASK-1"
     * }
     *
     * Response:
     * {
     *    "success": true
     * }
     */
    public function close(Request $request, CloseHandler $handler): JsonResponse
    {
        try {
            $params = json_decode($request->getContent(), true);
            $taskId = $params['taskId'] ?? '';
            $command = new CloseCommand($taskId);
            $task = $handler->handle($command);
            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }
    }

    /**
     * @Route("/list", name="list_task", methods={"POST"})
     * {
     *    "sprintId": "18-12"
     * }
     *
     * Response:
     * {
     *    "sprints": list of sprints or empty
     * }
     */
    public function getTasksForSprint(Request $request, TaskRepository $repository)
    {
        $params = json_decode($request->getContent(), true);
        $sprintId = $params['sprintId'];
        $tasks = $repository->getTasksBySprintId($sprintId);

        return new JsonResponse(['tasks' => $tasks]);
    }
}
