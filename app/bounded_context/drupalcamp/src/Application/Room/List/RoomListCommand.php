<?php

declare(strict_types=1);

namespace drupalcamp\Application\Room\List;

use drupalcamp\Domain\Command;

class RoomListCommand implements Command
{
  public function __construct(private array $fields)
  {
  }

  public function fields(): array
  {
    return $this->fields;
  }

}
