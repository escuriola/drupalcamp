<?php

declare(strict_types=1);

namespace drupalcamp\Infrastructure\Drupal\Adapter\Room;

use Drupal\Core\Controller\ControllerBase;
use drupalcamp\Application\Room\UpdateName\RoomUpdateNameCommand;
use drupalcamp\Application\Room\UpdateName\RoomUpdateNameApplicationService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RoomUpdateNameController extends ControllerBase
{
  private $service;

  public function __construct(RoomUpdateNameApplicationService $service)
  {
    $this->service = $service;
  }

  public function execute(Request $request): JsonResponse
  {
    $newName = $request->get('new_name');
    $room_id = $request->get('roomId');

    $command = new RoomUpdateNameCommand(
      $room_id,
      $newName,
    );

    $this->service->execute($command);

    return new JsonResponse([
      'status' => 'ok',
      'message' => 'The room name has been changed successfully',
    ]);

  }

  public static function create(ContainerInterface $container)
  {
    return new static (
      $container->get('room.update_name_service')
    );
  }

}
