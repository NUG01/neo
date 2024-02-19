<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignFormRequest;
use App\Http\Services\CampaignService;
use App\Models\Campaign;
use App\Models\Participation;
use App\Models\StepFieldValue;
use App\Repositories\CampaignRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CampaignFrontendController extends Controller
{

	public function index()
	{
		$participations = Participation::paginate(20);
		return view('participations', compact('participations'));
	}
	/** 
	 * displays the template file for a given campaign step
	 * based on current step id stored in session
	 */
	public function display(Request $request, Campaign $campaign)
	{
		/** TO DO:
		 * write the logic that returns the view for the current step
		 * a campaign's title should be returned with the view
		 * if a campaign's end_date is reached, return an "expired" blade instead
		 **/

		if ($campaign->end_date < now()) return view('expired');

		$step = session_step_item($campaign);

		(new CampaignRepository())->insertParticipation($campaign, $step);


		$title = $step->title;
		return view('steps.' . $step->fileName, compact('title'));
	}

	/** 
	 * handles submit of form on campaign steps
	 * validates input based on StepFields
	 * stores data in Participation (enrich if not the first step)
	 */
	public function submit(CampaignFormRequest $request, Campaign $campaign)
	{
		/** TO DO:
		 * write the logic that handles the submit of a form on each step
		 * 1. all given StepFields of a Step are mandetory -> validate that each field was submitted / is not empty
		 * (we do not expect further validation of most values but if date_of_birth is given, the age has to be 18+. Write a custom validation)
		 * 2a. if validation fails, return with errors
		 * 2b. if validation succeeds, store data in Participation (add to session for next submit) and continue to next step
		 **/

		$participationData = $request->validated();
		$campaignService = new CampaignService();

		$participation =	Participation::findBySession();
		$old_data = $participation->data;

		if ($old_data) $participationData = array_merge($old_data, $participationData);

		$participation->update(['data' => $participationData]);

		if ($campaignService->completeCampaign($campaign, $participation)) {
			return redirect()->route('welcome')->with('success', 'Campaign completed successfully.');
		}

		$step_id = session_step_id($campaign);
		$participation->update(['step' => next_step($campaign, $step_id)->title]);

		return redirect()->route('campaign.display', ['campaign' => $campaign])->with('success', 'Step completed successfully.');
	}
}
