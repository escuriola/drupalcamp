<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Service\Room\RoomNameIsUnique;

use drupalcamp\Domain\DomainService;
use drupalcamp\Domain\Model\Room\Exceptions\RoomNameAlreadyExistsException;
use drupalcamp\Domain\Model\Room\RoomRepository;

class RoomNameIsUniqueDomainService implements DomainService
{
  public function __construct(private RoomRepository $roomRepository)
  {
  }

  public function execute(RoomNameIsUniqueCommand $roomNameIsUniqueCommand): bool
  {
    $roomNames = $this->roomRepository->getRoomNames();
    if (in_array($roomNameIsUniqueCommand->romName(), $roomNames, true)) {
      throw new RoomNameAlreadyExistsException();
    }
    return true;

  }
}
