<?php

use App\Models\Participation;
use App\Models\Step;

if (!function_exists('session_step')) {
  function session_step($campaign)
  {
    $participation = Participation::findBySession();
    return  $participation ? $participation->step : $campaign->firstStepTitle();
  }
}

if (!function_exists('session_step_item')) {
  function session_step_item($campaign)
  {
    $participation = Participation::findBySession();
    $step = Step::where('campaign_id', $campaign->id)->where('title', $participation->step)->first();
    return  $step ? $step : $campaign->firstStep();
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

if (!function_exists('next_step')) {
  function next_step($campaign, $step_id)
  {
    return $campaign->steps->where('id', $step_id + 1)->firstOrFail();
  }
}
