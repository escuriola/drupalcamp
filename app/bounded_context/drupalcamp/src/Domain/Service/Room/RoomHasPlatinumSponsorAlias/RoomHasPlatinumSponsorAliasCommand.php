<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Service\Room\RoomHasPlatinumSponsorAlias;

use drupalcamp\Domain\DomainService;

class RoomHasPlatinumSponsorAliasCommand implements DomainService
{
  public function __construct(private string $roomName)
  {
  }

  public function roomName(): string
  {
    return $this->roomName;
  }
}
