<?php

namespace App\Http\Requests;

use App\Http\Services\CampaignService;
use App\Models\Campaign;
use App\Models\Participation;
use App\Rules\AgeCheck;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class CampaignFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $campaign = $this->route('campaign');
        $step = (new CampaignService())->determineStep($campaign);

        if ($step === 'step-1') {
            return [
                'salutation' => ['required', 'string'],
                'firstname' => ['required', 'string'],
                'lastname' => ['required', 'string'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'postal_code' => ['nullable', 'prohibited'],
                'city' => ['nullable', 'prohibited'],
                'street' => ['nullable', 'prohibited'],
                'country' => ['nullable', 'prohibited'],
                'date_of_birth' => ['nullable', 'prohibited'],
            ];
        } elseif ($step === 'step-2') {
            return [
                'postal_code' => ['required', 'numeric'],
                'city' => ['required', 'string'],
                'street' => ['required', 'string'],
                'country' => ['required', 'string'],
                'date_of_birth' => ['required', 'date', new AgeCheck()],
                'salutation' => ['nullable', 'prohibited'],
                'firstname' => ['nullable', 'prohibited'],
                'lastname' => ['nullable', 'prohibited'],
                'email' => ['nullable', 'prohibited'],
                'phone' => ['nullable', 'prohibited'],
            ];
        }

        return [];
    }
}
