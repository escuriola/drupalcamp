<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Model\Room;

interface RoomRepository
{
  public function save(Room $room);

  public function byName(string $name): Room;

  public function list(): RoomCollection;

  public function getRoomNames(): array;

}
