<?php

declare(strict_types=1);

namespace drupalcamp\Domain\Model\Sponsor\SponsorLabel;

class SponsorLabel
{
  public function __construct(private SponsorLabelId $sponsorLabelId, private $label, private $logo, private bool $paid)
  {
  }

  public function sponsorLabelId(): SponsorLabelId
  {
    return $this->sponsorLabelId;
  }

  /**
   * @return mixed
   */
  public function label()
  {
    return $this->label;
  }

  /**
   * @return mixed
   */
  public function logo()
  {
    return $this->logo;
  }

  public function isPaid(): bool
  {
    return $this->paid;
  }

}
