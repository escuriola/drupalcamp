<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Model\Room;

use drupalcamp\Domain\DomainEvent;

class RoomCreatedDomainEvent extends DomainEvent
{
  public function __construct(
    string $id,
    private string $name,
    private string $building,
    private string $address,
    private int $floor,
    string $eventId = null,
    string $occurredOn = 'xxx'
  ) {
    parent::__construct($id, $eventId, $occurredOn);
  }

  public static function eventName(): string
  {
    return 'room.created';
  }

  public static function fromPrimitives(
    string $aggregateId,
    array $body,
    string $eventId,
    string $occurredOn
  ): RoomCreatedDomainEvent {
    return new self(
      $aggregateId,
      $body['name'],
      $body['building'],
      $body['address'],
      $body['floor'],
      $eventId,
      $occurredOn
    );
  }

  public function toPrimitives(): array
  {
    return [
      'name'      => $this->name,
      'building'     => $this->building,
      'address'       => $this->address,
      'floor' => $this->floor,
    ];
  }
}
