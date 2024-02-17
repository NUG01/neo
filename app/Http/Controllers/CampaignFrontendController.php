<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Participation;
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
				'campaign_id' => '268cc50b-f88f-4940-938f-0b2c397b2966'
			]
		);
		// $participation = Participation::where('session_id', $session_id)->first();
		$request->session()->put('step', $step);
		return redirect()->back();
	}
	/** 
	 * displays the template file for a given campaign step
	 * based on current step id stored in session
	 */
	public function display(Request $request, Campaign $campaign)
	{
		$session_id = Session::getId();
		$participation = Participation::where('session_id', $session_id)->first();
		$participation_step = $participation->step;

		if ($campaign->end_date < now()) {
			return view('expired');
		}
		$title = $participation_step ?? $campaign->steps->first()->title;
		$step = $campaign->steps->where('title', $title)->first();
		// dd($step);

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
	public function submit(Request $request, Campaign $campaign)
	{
		/** TO DO:
		 * write the logic that handles the submit of a form on each step
		 * 1. all given StepFields of a Step are mandetory -> validate that each field was submitted / is not empty
		 * (we do not expect further validation of most values but if date_of_birth is given, the age has to be 18+. Write a custom validation)
		 * 2a. if validation fails, return with errors
		 * 2b. if validation succeeds, store data in Participation (add to session for next submit) and continue to next step
		 **/
	}

	// public function index()
	// {
	// 	$participations = Participation::paginate(20);
	// 	return view('participations.index', compact('participations'));
	// }
}
