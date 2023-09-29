<?php

declare(strict_types=1);

namespace drupalcamp\Tests\Application\room\UpdateName;

use drupalcamp\Application\Room\UpdateName\RoomUpdateNameCommand;
use drupalcamp\Application\Room\UpdateName\RoomUpdateNameApplicationService;
use drupalcamp\Domain\Model\Room\Room;
use drupalcamp\Domain\Model\Room\RoomId;
use drupalcamp\Domain\Model\Room\RoomRepository;
use PHPUnit\Framework\TestCase;

class RoomUpdateNameServiceTest extends TestCase
{
  const ROOM_ID = '2131';
  const ROOM_NAME = 'NTT Data';
  const ROOM_NEW_NAME = '1xInternet';

  /** @test */
  public function should_update_room_name(): void
  {
    $room = new Room(
      RoomId::fromString(self::ROOM_ID),
      self::ROOM_NAME,
      'ETSI',
      'Reina Mercedes',
      3
    );

    $roomRepository = $this->createMock(RoomRepository::class);
    $roomRepository->expects($this->once())
      ->method('byName')
      ->willReturn($room);

    $roomRepository->expects($this->once())
      ->method('save')
      ->with($this->equalTo($room));

    $service = new RoomUpdateNameApplicationService($roomRepository);
    $command = new RoomUpdateNameCommand(
      self::ROOM_ID,
      self::ROOM_NEW_NAME,
    );
    $service->execute($command);

    $this->assertEquals(self::ROOM_NEW_NAME, $room->name());
  }

}
