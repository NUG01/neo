<?php

use App\Models\Participation;
use App\Models\Step;

if (!function_exists('session_step')) {
  function session_step($campaign)
  {
    $participation = Participation::findBySession();
    return  $participation ? $participation->step : $campaign->stepTitle();
  }
}

if (!function_exists('session_step_id')) {
  function session_step_id($campaign)
  {
    $participation = Participation::findBySession();
    $step = Step::where('campaign_id', $campaign->id)->where('title', $participation->step)->first();
    return $step ? $step->id : $campaign->steps->first()->id;
  }
}

if (!function_exists('campaign_first_step')) {
  function get_campaign_first_step($campaign)
  {
    return $campaign->stepTitle();
  }
}


if (!function_exists('campaign_last_step')) {
  function get_campaign_last_step($campaign)
  {
    return $campaign->lastStepTitle();
  }
}
