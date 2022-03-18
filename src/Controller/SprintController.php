<?php

declare(strict_types=1);

namespace App\Controller;

use App\Module\Sprint\Repository\SprintRepository;
use App\Module\Sprint\UseCase\Add\Command as CreateCommand;
use App\Module\Sprint\UseCase\Close\Command as CloseCommand;
use App\Module\Sprint\UseCase\Add\Handler as CreateHandler;
use App\Module\Sprint\UseCase\Close\Handler as CloseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/sprints")
 */
class SprintController extends AbstractController
{
    /**
     * @Route("", name="create_sprint", methods={"POST"})
     * Request:
     * {
     *    "year": "2018",
     *    "week": "12"
     * }
     *
     * Response:
     * {
     *    "id": "18-12"
     * }
     */
    public function create(Request $request, CreateHandler $handler): JsonResponse
    {

        try {
            $params = json_decode($request->getContent(), true);
            $year = $params['year'] ?? '';
            $week = $params['week'] ?? '';
            $command = new CreateCommand($year, $week);
            $sprint = $handler->handle($command);
            return new JsonResponse(['id' => $sprint->getGeneratedId()]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }
    }

    /**
     * @Route("/close", name="close_sprint", methods={"POST"})
     * {
     *    "sprintId": "18-12"
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
            $sprintId = $params['sprintId'] ?? '';
            $command = new CloseCommand($sprintId);
            $sprint = $handler->handle($command);
            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }
    }

    /**
     * @Route("/list", name="list_sprint", methods={"GET"})
     * @param SprintRepository $repository
     * @return JsonResponse
     */
    public function getSprintList(SprintRepository $repository): JsonResponse
    {
        $sprints = $repository->getAllSprints();
        return new JsonResponse(['sprints' => $sprints]);
    }
}
