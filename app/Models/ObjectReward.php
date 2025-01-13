<?php

namespace App\Models;

class ObjectReward extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_id', 'object_type', 'rewardable_id', 'rewardable_type', 'quantity', 'recipient_type', 'reward_key',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'object_rewards';

    /**********************************************************************************************
    RELATIONS
     **********************************************************************************************/

    /**
     * Get the object.
     */
    public function object() {
        return $this->morphTo(__FUNCTION__, 'object_type', 'object_id');
    }

    /**
     * Get the reward attached to the prompt reward.
     */
    public function reward() {
        return $this->morphTo(__FUNCTION__, 'rewardable_type', 'rewardable_id');
    }

    /**
     * Get the reward type so we don't have to do the no-no of model names in forms.
     */
    public function rewardType() {
        return class_basename($this->rewardable_type);
    }
}
