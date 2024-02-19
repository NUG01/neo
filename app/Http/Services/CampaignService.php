<?php

namespace App\Http\Services;


class CampaignService
{

  public function completeCampaign($campaign, $participation)
  {
    if ($participation->step === $campaign->lastStepTitle()) {
      $participation->update(['completed' => true, 'step' => null, 'session_id' => null]);
      return true;
    }

    return false;
  }


  public function determineStep($campaign)
  {
    return session_step($campaign);
  }
}
