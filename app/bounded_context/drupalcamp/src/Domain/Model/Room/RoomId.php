<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Model\Room;

use drupalcamp\Domain\Model\Room\Exceptions\InvalidRoomIdException;

class RoomId
{
  private $id;

  public function __construct(string $id)
  {
    $this->guard($id);

    $this->id = $id;
  }

  public static function fromString(string $value): RoomId
  {
    return new self($value);
  }

  public function id(): string
  {
    return $this->id;
  }

  private function guard(string $id): void
  {
    if (empty($id)) {
      throw new InvalidRoomIdException("The roomId is empty");
    }
  }


}
