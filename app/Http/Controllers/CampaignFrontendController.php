<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignFormRequest;
use App\Models\Campaign;
use App\Models\Participation;
use App\Models\StepFieldValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CampaignFrontendController extends Controller
{

	public function session(Request $request, $step)
	{
		$session_id = Session::getId();
		Participation::updateOrCreate(
			['session_id' => $session_id],
			[
				'step' => $step,
				'campaign_id' => '4c312801-e639-442b-baa2-d143c9e846f4'
			]
		);
		// $participation = Participation::where('session_id', $session_id)->first();
		// $request->session()->put('step', $step);
		return redirect()->route('campaign.display', ['campaign' => '4c312801-e639-442b-baa2-d143c9e846f4']);
	}
	/** 
	 * displays the template file for a given campaign step
	 * based on current step id stored in session
	 */
	public function display(Request $request, Campaign $campaign)
	{
		$session_id = Session::getId();
		$participation = Participation::where('session_id', $session_id)->first();

		$new_partipication =	Participation::updateOrCreate(
			['session_id' => $session_id, 'campaign_id' => $campaign->id],
			[
				'step' => $participation ? $participation->step : $campaign->steps->first()->title,

			]
		);

		$participation_step = $new_partipication->step;

		if ($campaign->end_date < now()) {
			return view('expired');
		}
		$title = $participation_step ?? $campaign->steps->first()->title;
		$step = $campaign->steps->where('title', $title)->first();

		return view('steps.' . $step->fileName, compact('title'));
		/** TO DO:
		 * write the logic that returns the view for the current step
		 * a campaign's title should be returned with the view
		 * if a campaign's end_date is reached, return an "expired" blade instead
		 **/
	}

	/** 
	 * handles submit of form on campaign steps
	 * validates input based on StepFields
	 * stores data in Participation (enrich if not the first step)
	 */
	public function submit(CampaignFormRequest $request, Campaign $campaign)
	{

		$participationData = $request->validated();
		$participation =	Participation::findBySession();
		$old_data = $participation->data;


		foreach ($campaign->steps as $key => $value) {
			foreach ($value->fields as $i => $field) {
				if ($field->step_id != session_step_id($campaign)) continue;
				StepFieldValue::create([
					'step_field_id' => $value->id,
					'participation_id' => $participation->id,
					'value' => $participationData[$field->input]
				]);
			}
		}


		$step_id = session_step_id($campaign);
		if ($old_data) $participationData = array_merge($old_data, $participationData);

		$participation->update(['data' => $participationData]);

		$next_step = $campaign->steps->where('id', $step_id + 1)->first();
		if ($participation->step === $campaign->lastStepTitle()) {
			Session::put('step', $next_step->title);
			$participation->update(['completed' => true]);
			return redirect()->route('welcome')->with('success', 'Campaign completed successfully.');
		}

		$participation->update(['step' => $next_step->title]);

		/** TO DO:
		 * write the logic that handles the submit of a form on each step
		 * 1. all given StepFields of a Step are mandetory -> validate that each field was submitted / is not empty
		 * (we do not expect further validation of most values but if date_of_birth is given, the age has to be 18+. Write a custom validation)
		 * 2a. if validation fails, return with errors
		 * 2b. if validation succeeds, store data in Participation (add to session for next submit) and continue to next step
		 **/
		return redirect()->route('campaign.display', ['campaign' => $campaign])->with('success', 'Step completed successfully.');
	}

	public function index()
	{
		$participations = Participation::paginate(20);
		return view('participations', compact('participations'));
	}
}
