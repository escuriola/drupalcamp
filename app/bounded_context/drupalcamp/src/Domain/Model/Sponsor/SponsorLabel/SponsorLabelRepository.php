<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Model\Sponsor\SponsorLabel;

interface SponsorLabelRepository
{
  public function save(SponsorLabel $sponsorLabel);

  public function byId(SponsorLabelId $sponsorLabelId): SponsorLabel;

}
