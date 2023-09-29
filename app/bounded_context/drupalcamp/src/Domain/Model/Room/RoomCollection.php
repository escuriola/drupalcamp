<?php
declare(strict_types=1);

namespace drupalcamp\Domain\Model\Room;

use drupalcamp\Domain\Model\Room\Exceptions\InvalidRoomException;

class RoomCollection
{
  /**
   * @var Room[]
   */
  private array $rooms;

  public function __construct(array $rooms)
  {
    foreach ($rooms as $room) {
      if ($room instanceof Room === false) {
        throw new InvalidRoomException('The room should be instances of ' . Room::class);
      }

      $this->add($room);
    }
  }

  public static function fromArray(array $rooms): RoomCollection
  {
    return new static($rooms);
  }

  public function roomList(): array
  {
    return $this->rooms;
  }

  private function add(Room $room)
  {
    $this->rooms[] = $room;
  }
}
