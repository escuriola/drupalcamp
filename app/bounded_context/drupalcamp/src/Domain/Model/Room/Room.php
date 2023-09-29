<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Model\Room;

use drupalcamp\Domain\Entity;
use drupalcamp\Domain\Model\Room\Exceptions\BannedRoomNamesException;

final class Room extends Entity
{
  public function __construct(
    private RoomId $roomId,
    private string $name,
    private string $building,
    private string $address,
    private int $floor
  )
  {

  }

  public static function create(RoomId $roomId, string $name, string $building, string $address, int $floor): Room
  {
    $room = new self($roomId, $name, $building, $address, $floor);
    self::isNotBannedName($name);

    $room->record(new RoomCreatedDomainEvent(
      $roomId->id(),
      $name,
      $building,
      $address,
      $floor
    ));

    return $room;
  }

  public function roomId(): RoomId
  {
    return $this->roomId;
  }

  public function name(): string
  {
    return $this->name;
  }

  public function building(): string
  {
    return $this->building;
  }

  public function address(): string
  {
    return $this->address;
  }

  public function floor(): int
  {
    return $this->floor;
  }

  public function updateName(string $newName): void
  {
    $this->name = $newName;
  }

  private static function isNotBannedName(string $name): void
  {
    if (in_array($name, ['Wordpress', 'Joomla', 'Mambo', 'Typo3'], true)) {
      throw new BannedRoomNamesException('Room name is invalid');
    }
  }

}
