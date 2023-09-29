<?php

declare(strict_types=1);

namespace drupalcamp\Application\Room\List;

use drupalcamp\Domain\ApplicationService;
use drupalcamp\Domain\Model\Room\Exceptions\ListRoomsException;
use drupalcamp\Domain\Model\Room\Room;
use drupalcamp\Domain\Model\Room\RoomRepository;

class RoomListApplicationService implements ApplicationService
{
  public function __construct(private RoomRepository $roomRepository)
  {
  }

  public function execute(RoomListCommand $listRoomsCommand)
  {
    $roomCollection = $this->roomRepository->list();
    $fields = $listRoomsCommand->fields();
    if (empty($fields)) {
      throw new ListRoomsException("Fields can not be empty");
    }
    $rooms = [];
    foreach ($roomCollection->roomList() as $room) {
      /** @var Room $room */
      $roomId = $room->roomId()->id();

      foreach ($fields as $field) {
        $rooms[$roomId][$field] = $room->{$field}();
      }
    }
    return $rooms;
  }

}
