<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Model\Sponsor;

interface SponsorRepository
{

  public function getSponsorAliases(): array;
}
