<?php

declare(strict_types=1);

namespace drupalcamp\Infrastructure\Drupal\Domain\Model\Room;

use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use drupalcamp\Domain\Model\Room\Exceptions\RoomCanNotBeCreatedException;
use drupalcamp\Domain\Model\Room\Exceptions\RoomNameNotExistingException;
use drupalcamp\Domain\Model\Room\Room;
use drupalcamp\Domain\Model\Room\RoomCollection;
use drupalcamp\Domain\Model\Room\RoomId;
use drupalcamp\Domain\Model\Room\RoomRepository;


class DrupalRoomRepository implements RoomRepository
{

  public function save(Room $room)
  {
    try {
      $existingNode = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['uuid' => $room->roomId()->id()]);
      if (!empty($existingNode)) {
        $newRoom = reset($existingNode);
      }
      else {
        $newRoom = Node::create(
          [
            'uuid' => $room->roomId()->id(),
            'type' => 'dc_room',
          ]
        );
      }

      $newRoom->set('title',  $room->name());
      $newRoom->set('field_room_building',  $room->building());
      $newRoom->set('field_room_address',  $room->address());
      $newRoom->set('field_room_floor',  $room->floor());

      $newRoom->save();
    } catch (\Exception $e) {
      throw new RoomCanNotBeCreatedException('Room can not be created ' .$e->getMessage() );
    }

  }

  public function byName(string $name): Room
  {
    $nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'title' => $name,
      ]);

    if (empty($nodes)) {
      throw new RoomNameNotExistingException();
    }

    /** @var NodeInterface $node */
   $node = reset($nodes);

   return Room::create(
     RoomID::fromString($node->uuid()),
     $node->getTitle(),
     $node->get('field_room_building')->value,
     $node->get('field_room_address')->value,
     (int) $node->get('field_room_floor')->value,

   );
  }

  public function list(): RoomCollection
  {
    $nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'dc_room',
      ]);

    $rooms = [];
    foreach ($nodes as $node) {
      $rooms[] = $this->byName($node->getTitle());
    }
    return RoomCollection::fromArray($rooms);
  }

  public function getRoomNames(): array
  {
    $nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'dc_room',
      ]);

    $rooms = [];
    foreach ($nodes as $node) {
      $rooms[] = $node->getTitle();
    }
    return $rooms;
  }
}
