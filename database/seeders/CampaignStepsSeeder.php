<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\Step;
use App\Models\StepField;

class CampaignStepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year_from_now = date('Y-m-d', strtotime('+1 year'));
        $campaign = Campaign::create(['title' => 'Neo campaign', 'end_date' => $year_from_now]);

        $steps = [
            ['campaign_id' => $campaign->id, 'title' => 'step-1', 'order_num' => 1, 'fileName' => 'StepOne'],
            ['campaign_id' => $campaign->id, 'title' => 'step-2', 'order_num' => 1, 'fileName' => 'StepTwo'],
        ];

        foreach ($steps as $step) {
            $created_step = Step::create($step);

            $step_fields_patterns = [
                'step-1' => ['salutation', 'firstname', 'lastname', 'email', 'phone'],
                'step-2' => ['date_of_birth', 'street', 'postal_code', 'city', 'country'],
            ];

            foreach ($step_fields_patterns[$step['title']] as $input) {
                StepField::create([
                    'step_id' => $created_step->id,
                    'input' => $input,
                ]);
            }
        }
    }
}
