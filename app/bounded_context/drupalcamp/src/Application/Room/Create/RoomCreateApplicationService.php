<?php

declare(strict_types=1);

namespace drupalcamp\Application\Room\Create;

use drupalcamp\Domain\ApplicationService;
use drupalcamp\Domain\Model\Room\Room;
use drupalcamp\Domain\Model\Room\RoomId;
use drupalcamp\Domain\Model\Room\RoomRepository;
use drupalcamp\Domain\Model\Sponsor\SponsorRepository;
use drupalcamp\Domain\Service\Room\RoomHasPlatinumSponsorAlias\RoomHasPlatinumSponsorAliasCommand;
use drupalcamp\Domain\Service\Room\RoomHasPlatinumSponsorAlias\RoomHasPlatinumSponsorAliasDomainService;
use drupalcamp\Domain\Service\Room\RoomNameIsUnique\RoomNameIsUniqueCommand;
use drupalcamp\Domain\Service\Room\RoomNameIsUnique\RoomNameIsUniqueDomainService;

class RoomCreateApplicationService implements ApplicationService
{
  public function __construct(private RoomRepository $roomRepository, private SponsorRepository $sponsorRepository)
  {
  }

  public function execute(RoomCreateCommand $roomCreateCommand)
  {
    $room = new Room(
      RoomId::fromString($roomCreateCommand->roomId()),
      $roomCreateCommand->name(),
      $roomCreateCommand->building(),
      $roomCreateCommand->address(),
      $roomCreateCommand->floor()
    );

    $roomNameHasPlatinumSponsorNameDomainService = new RoomHasPlatinumSponsorAliasDomainService($this->sponsorRepository);
    $roomNameHasPlatinumSponsorNameCommand = new RoomHasPlatinumSponsorAliasCommand($roomCreateCommand->name());
    $roomNameHasPlatinumSponsorNameDomainService->execute($roomNameHasPlatinumSponsorNameCommand);

    $roomNameIsUniqueDomainService = new RoomNameIsUniqueDomainService($this->roomRepository);
    $roomNameIsUniqueDomainCommand = new RoomNameIsUniqueCommand($roomCreateCommand->name());
    $roomNameIsUniqueDomainService->execute($roomNameIsUniqueDomainCommand);





    $this->roomRepository->save($room);
  }

}
