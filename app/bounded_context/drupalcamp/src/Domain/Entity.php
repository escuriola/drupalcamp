<?php

declare(strict_types=1);

namespace drupalcamp\Domain;

abstract class Entity
{
  private array $domainEvents = [];

  protected function record(DomainEvent $domainEvent): void
  {
    $this->domainEvents[] = $domainEvent;
  }

}
