<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Service\Room\RoomHasPlatinumSponsorAlias;

use drupalcamp\Domain\DomainService;
use drupalcamp\Domain\Model\Room\Exceptions\RoomNameIsNotSponsorAliasException;
use drupalcamp\Domain\Model\Sponsor\SponsorRepository;


class RoomHasPlatinumSponsorAliasDomainService implements DomainService
{
  public function __construct(private SponsorRepository $sponsorRepository)
  {
  }

  public function execute(RoomHasPlatinumSponsorAliasCommand $roomHasPlatinumSponsorAliasCommand): bool
  {
    $roomNames = $this->sponsorRepository->getSponsorAliases();
    if (!in_array($roomHasPlatinumSponsorAliasCommand->roomName(), $roomNames, true)) {
      throw new RoomNameIsNotSponsorAliasException();
    }
    return true;

  }
}
