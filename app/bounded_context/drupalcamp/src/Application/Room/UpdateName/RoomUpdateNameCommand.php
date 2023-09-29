<?php

declare(strict_types=1);

namespace drupalcamp\Application\Room\UpdateName;

use drupalcamp\Domain\Command;

class RoomUpdateNameCommand implements Command
{
  public function __construct(private string $oldName, private string $newName)
  {
  }

  public function oldName(): string
  {
    return $this->oldName;
  }

  public function newName(): string
  {
    return $this->newName;
  }

}
