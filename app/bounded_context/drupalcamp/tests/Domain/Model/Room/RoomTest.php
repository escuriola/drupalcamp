<?php

declare(strict_types=1);

namespace drupalcamp\Tests\Domain\Model\Room;

use drupalcamp\Domain\Model\Room\Exceptions\BannedRoomNamesException;
use drupalcamp\Domain\Model\Room\Room;
use drupalcamp\Domain\Model\Room\RoomId;
use PHPUnit\Framework\TestCase;


class RoomTest extends TestCase
{
  const ROOM_ID = 'XX22';
  const ROOM_NAME = 'Room 5';
  const NEW_ROOM_NAME = 'New Room XX';
  const BUILDING_NAME = 'Giralda';
  const ADDRESS = 'Torcuato Luca de Tena, 22';
  const BANNED_NAME = 'Wordpress';


  /** @test */
  public function should_create_a_room(): void
  {
    $roomId = RoomId::fromString(self::ROOM_ID);

    $room = Room::create(
      $roomId,
      self::ROOM_NAME,
      self::BUILDING_NAME,
      self::ADDRESS,
      1,
    );

    $this->assertSame(self::ROOM_NAME, $room->name());
    $this->assertSame(self::BUILDING_NAME, $room->building());
    $this->assertSame(self::ADDRESS, $room->address());
    $this->assertSame(1, $room->floor());
  }

  /** @test */
  public function should_thrown_an_exception_if_name_is_banned(): void
  {
    $this->expectException(BannedRoomNamesException::class);

    $roomId = RoomId::fromString(self::ROOM_ID);

     Room::create(
      $roomId,
      self::BANNED_NAME,
      self::BUILDING_NAME,
      self::ADDRESS,
      1,
    );

  }

  /** test */
  public function should_change_the_name()
  {
    $roomId = RoomId::fromString(self::ROOM_ID);

    $room = Room::create(
      $roomId,
      self::ROOM_NAME,
      self::BUILDING_NAME,
      self::ADDRESS,
      1,
    );

    $this->assertSame(self::ROOM_NAME, $room->name());
    $room->updateName('Hiberus');

    $this->assertSame('Hiberus', $room->name());
  }


}
