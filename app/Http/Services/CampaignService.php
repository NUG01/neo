<?php

namespace App\Http\Services;


class CampaignService
{
  public function determineStep($campaign)
  {
    return session_step($campaign);
  }
}
