<?php

namespace App\Console\Commands;

use App\Models\ObjectReward;
use App\Models\Prompt\PromptReward;
use Illuminate\Console\Command;
use DB;

class UpdateRewardMaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-reward-maker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update reward maker for develop';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dd(DB::table('prompt_rewards'));
        //while this will convert prompt rewards to the new system
        //the first half if for those who used the existing ext and have existing data

        $rewards = ObjectReward::all();

        foreach ($rewards as $reward) {

            switch ($reward->object_type) {
                case 'Questline':
                    $objmodel = 'App\Models\Questline\Questline';
                    break;
                case 'Prompt':
                    $objmodel = 'App\Models\Prompt\Prompt';
                    break;
            }

            switch ($reward->recipient_type) {
                case 'User':
                    $key = 'objectRewards';
                    break;
                case 'Character':
                    $key = 'objectCharacterRewards';
                    break;
            }

            $reward->update([
                'rewardable_type' => getAssetModelString(strtolower($reward->rewardable_type)),
                'object_type' => $objmodel,
                'reward_key' => $key,
            ]);
        }


        foreach (PromptReward::all() as $promptreward) {
            $rewardmodel = getAssetModelString(strtolower($promptreward->rewardable_type));

            $newreward = ObjectReward::create([
                'object_id' => $promptreward->prompt_id,
                'object_type' => 'App\Models\Prompt\Prompt',
                'rewardable_type' => $rewardmodel,
                'rewardable_id' => $promptreward->rewardable_id,
                'quantity' => $promptreward->quantity,
                'recipient_type' => 'User',
                'reward_key' => 'objectRewards',
            ]);

            if (!$newreward) {
                $this->error('Error. Skipping prompt reward for prompt: ' . $promptreward->prompt->name);
            }
        }
    }
}
