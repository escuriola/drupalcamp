<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Service\Room\RoomNameIsUnique;

use drupalcamp\Domain\DomainService;

class RoomNameIsUniqueCommand implements DomainService
{
  public function __construct(private string $roomName)
  {
  }

  public function romName(): string
  {
    return $this->roomName;
  }
}
