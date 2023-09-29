<?php

declare(strict_types=1);

namespace drupalcamp\Infrastructure\Drupal\Domain\Model\Sponsor;

use drupalcamp\Domain\Model\Sponsor\SponsorRepository;

class MemorySponsorRepository implements SponsorRepository
{

  public function getSponsorAliases(): array
  {
    return ['NTT Data', '1xInternet', 'Minsait', 'Hiberus'];
  }
}
