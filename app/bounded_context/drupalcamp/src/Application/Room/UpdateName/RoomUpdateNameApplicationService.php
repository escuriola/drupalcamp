<?php

declare(strict_types=1);

namespace drupalcamp\Application\Room\UpdateName;

use drupalcamp\Domain\ApplicationService;
use drupalcamp\Domain\Model\Room\RoomRepository;
use drupalcamp\Domain\Model\Sponsor\SponsorRepository;
use drupalcamp\Domain\Service\Room\RoomHasPlatinumSponsorAlias\RoomHasPlatinumSponsorAliasCommand;
use drupalcamp\Domain\Service\Room\RoomHasPlatinumSponsorAlias\RoomHasPlatinumSponsorAliasDomainService;
use drupalcamp\Domain\Service\Room\RoomNameIsUnique\RoomNameIsUniqueCommand;
use drupalcamp\Domain\Service\Room\RoomNameIsUnique\RoomNameIsUniqueDomainService;

class RoomUpdateNameApplicationService implements ApplicationService
{
  public function __construct(private RoomRepository $roomRepository, private SponsorRepository $sponsorRepository)
  {
    $this->roomRepository = $roomRepository;
  }

  public function execute(RoomUpdateNameCommand $roomUpdateNameCommand)
  {
    $room = $this->roomRepository->byName($roomUpdateNameCommand->oldName());
    $room->updateName($roomUpdateNameCommand->newName());

    $roomNameHasPlatinumSponsorNameDomainService = new RoomHasPlatinumSponsorAliasDomainService($this->sponsorRepository);
    $roomNameHasPlatinumSponsorNameCommand = new RoomHasPlatinumSponsorAliasCommand($roomUpdateNameCommand->newName());
    $roomNameHasPlatinumSponsorNameDomainService->execute($roomNameHasPlatinumSponsorNameCommand);

    $roomNameIsUniqueDomainService = new RoomNameIsUniqueDomainService($this->roomRepository);
    $roomNameIsUniqueDomainCommand = new RoomNameIsUniqueCommand($roomUpdateNameCommand->newName());
    $roomNameIsUniqueDomainService->execute($roomNameIsUniqueDomainCommand);

    $this->roomRepository->save($room);
  }

}
