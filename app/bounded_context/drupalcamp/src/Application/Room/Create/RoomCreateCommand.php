<?php

declare(strict_types=1);

namespace drupalcamp\Application\Room\Create;

use drupalcamp\Domain\Command;

class RoomCreateCommand implements Command
{
  private string $id;
  private string $name;
  private string $building;
  private string $address;
  private int $floor;

  public function __construct(string $id, string $name, string $building, string $address, int $floor)
  {
    $this->id = $id;
    $this->name = $name;
    $this->building = $building;
    $this->address = $address;
    $this->floor = $floor;
  }

  public function roomId(): string
  {
    return $this->id;
  }

  public function name(): string
  {
    return $this->name;
  }

  public function building(): string
  {
    return $this->building;
  }

  public function address(): string
  {
    return $this->address;
  }

  public function floor(): int
  {
    return $this->floor;
  }

}
