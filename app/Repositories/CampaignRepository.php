<?php

namespace App\Repositories;

use App\Models\Participation;
use Illuminate\Support\Facades\Session;


class CampaignRepository
{
  public function insertParticipation($campaign, $step)
  {
    $session_id = Session::getId();
    Participation::updateOrCreate(
      ['session_id' => $session_id, 'campaign_id' => $campaign->id, 'completed' => false],
      ['step' => $step->title]
    );
  }
}
