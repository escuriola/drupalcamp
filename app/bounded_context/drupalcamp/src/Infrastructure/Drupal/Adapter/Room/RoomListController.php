<?php

declare(strict_types=1);

namespace drupalcamp\Infrastructure\Drupal\Adapter\Room;

use Drupal\Core\Controller\ControllerBase;
use drupalcamp\Application\Room\List\RoomListApplicationService;
use drupalcamp\Application\Room\List\RoomListCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RoomListController extends ControllerBase
{
  private $service;

  public function __construct(RoomListApplicationService $service)
  {
    $this->service = $service;
  }

  public function execute(Request $request): JsonResponse
  {
    $fields = explode(',', $request->get('fields'));

    $command = new RoomListCommand($fields);

    $rooms = $this->service->execute($command);

    return new JsonResponse($rooms);
  }

  public static function create(ContainerInterface $container)
  {
    return new static (
      $container->get('room.list_service')
    );
  }

}
