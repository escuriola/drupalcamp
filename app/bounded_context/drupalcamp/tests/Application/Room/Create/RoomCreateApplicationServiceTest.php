<?php

declare(strict_types=1);

namespace drupalcamp\Tests\Application\Room\Create;

use drupalcamp\Application\Room\Create\RoomCreateCommand;
use drupalcamp\Application\Room\Create\RoomCreateApplicationService;
use drupalcamp\Domain\Model\Room\Exceptions\RoomNameAlreadyExistsException;
use drupalcamp\Domain\Model\Room\Exceptions\RoomNameIsNotSponsorAliasException;
use drupalcamp\Domain\Model\Room\Room;
use drupalcamp\Domain\Model\Room\RoomId;
use drupalcamp\Domain\Model\Room\RoomRepository;
use drupalcamp\Domain\Model\Sponsor\SponsorRepository;
use drupalcamp\Domain\Service\Room\RoomHasPlatinumSponsorAlias\RoomHasPlatinumSponsorAliasDomainService;
use drupalcamp\Domain\Service\Room\RoomNameIsUnique\RoomNameIsUniqueDomainService;
use PHPUnit\Framework\TestCase;

class RoomCreateApplicationServiceTest extends TestCase
{
  const ROOM_ID = '2131';
  const ROOM_NAME = 'Azul';
  const BUILDING = 'Alfonso XXX';
  const ADDRESS = 'Torcuato Luca de Tena 2';
  const FLOOR = 2;

  /** @test */
  public function should_create_a_validated_room(): void
  {
    $room = Room::create(
      RoomId::fromString(self::ROOM_ID),
      self::ROOM_NAME,
      self::BUILDING,
      self::ADDRESS,
      self::FLOOR,
    );

    $sponsorRepository = $this->createMock(SponsorRepository::class);
    $sponsorRepository->expects($this->once())
      ->method('getSponsorAliases')
      ->willReturn([self::ROOM_NAME]);

    $roomRepository = $this->createMock(RoomRepository::class);

    $roomRepository->expects($this->once())
      ->method('getRoomNames')
      ->willReturn([]);

    $roomRepository->expects($this->once())
      ->method('save')
      ->willReturn($room);

    $service = new RoomCreateApplicationService($roomRepository, $sponsorRepository);
    $command = new RoomCreateCommand(
      self::ROOM_ID,
      self::ROOM_NAME,
      self::BUILDING,
      self::ADDRESS,
      self::FLOOR
    );
    $service->execute($command);
  }

  /** @test */
  public function should_not_create_a_room_if_name_already_exists(): void
  {
    $this->expectException(RoomNameAlreadyExistsException::class);

    $room = Room::create(
      RoomId::fromString(self::ROOM_ID),
      self::ROOM_NAME,
      self::BUILDING,
      self::ADDRESS,
      self::FLOOR,
    );

    $sponsorRepository = $this->createMock(SponsorRepository::class);
    $sponsorRepository->expects($this->once())
      ->method('getSponsorAliases')
      ->willReturn([self::ROOM_NAME]);

    $roomRepository = $this->createMock(RoomRepository::class);

    $roomRepository->expects($this->once())
      ->method('getRoomNames')
      ->willReturn([self::ROOM_NAME]);


    $service = new RoomCreateApplicationService($roomRepository, $sponsorRepository);
    $command = new RoomCreateCommand(
      self::ROOM_ID,
      self::ROOM_NAME,
      self::BUILDING,
      self::ADDRESS,
      self::FLOOR
    );
    $service->execute($command);
  }

  /** @test */
  public function should_not_create_a_room_if_name_is_not_platinum_sponsor_company_name(): void
  {
    $this->expectException(RoomNameIsNotSponsorAliasException::class);

    $room = Room::create(
      RoomId::fromString(self::ROOM_ID),
      self::ROOM_NAME,
      self::BUILDING,
      self::ADDRESS,
      self::FLOOR,
    );

    $sponsorRepository = $this->createMock(SponsorRepository::class);
    $sponsorRepository->expects($this->once())
      ->method('getSponsorAliases')
      ->willReturn([]);

    $roomRepository = $this->createMock(RoomRepository::class);

    $service = new RoomCreateApplicationService($roomRepository, $sponsorRepository);
    $command = new RoomCreateCommand(
      self::ROOM_ID,
      self::ROOM_NAME,
      self::BUILDING,
      self::ADDRESS,
      self::FLOOR
    );
    $service->execute($command);
  }

}
