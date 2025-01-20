<?php

namespace App\Models\Trade;

use App\Models\Character\Character;
use App\Models\Model;
use App\Models\User\User;
use App\Traits\Commentable;
use Carbon\Carbon;

class TradeListing extends Model {
    use Commentable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'comments', 'contact', 'expires_at', 'title',  'data',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trade_listings';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data'       => 'array',
        'expires_at' => 'datetime',
    ];

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * Validation rules for character creation.
     *
     * @var array
     */
    public static $createRules = [
        'title'        => 'nullable|between:3,50',
        'comments'     => 'nullable',
        'contact'      => 'required',
        'seeking_etc'  => 'nullable|between:3,100',
        'offering_etc' => 'nullable|between:3,100',
    ];

    /**
     * Validation rules for character updating.
     *
     * @var array
     */
    public static $updateRules = [
        'title'        => 'nullable|between:3,50',
        'comments'     => 'nullable',
        'contact'      => 'required',
        'seeking_etc'  => 'nullable|between:3,100',
        'offering_etc' => 'nullable|between:3,100',
    ];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the user who posted the trade listing.
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**********************************************************************************************

        SCOPES

    **********************************************************************************************/

    /**
     * Scope a query to only include active trade listings.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query) {
        return $query->where(function ($query) {
            $query->where('expires_at', '>', Carbon::now())->orWhere(function ($query) {
                $query->where('expires_at', '>=', Carbon::now());
            });
        });
    }

    /**
     * Scope a query to only include active trade listings.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query) {
        return $query->where(function ($query) {
            $query->where('expires_at', '<', Carbon::now())->orWhere(function ($query) {
                $query->where('expires_at', '<=', Carbon::now());
            });
        });
    }

    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/

    /**
     * Gets the Display Name of the trade listing.
     *
     * @return string
     */
    public function getDisplayNameAttribute() {
        if ($this->title == null) {
            return $this->user->displayName.'\'s <a href="'.$this->url.'">Trade Listing</a> (#'.$this->id.')';
        } else {
            return '<a href="'.$this->url.'" data-toggle="tooltip" title="'.$this->user->name.'\'s trade listing.">'.$this->title.'</a> (Trade Listing #'.$this->id.')';
        }
    }

    /**
     * Gets the Display Name of the trade listing with the title portion somewhat shorter.
     *
     * @return string
     */
    public function getDisplayNameShortAttribute() {
        if ($this->title == null) {
            return $this->user->displayName.'\'s <a href="'.$this->url.'">Trade Listing</a> (#'.$this->id.')';
        } else {
            return '<a href="'.$this->url.'" data-toggle="tooltip" title="'.$this->user->name.'\'s trade listing.">'.$this->title.'</a>';
        }
    }

    /**
     * Gets the name for the trade listing for use in forms.
     *
     * @return string
     */
    public function getFormNameAttribute() {
        return $this->title.' (Trade Listing #'.$this->id.')';
    }

    /**
     * Check if the trade listing is active.
     *
     * @return bool
     */
    public function getIsActiveAttribute() {
        if ($this->expires_at >= Carbon::now()) {
            return true;
        }

        return false;
    }

    /**
     * Gets the URL of the trade listing.
     *
     * @return string
     */
    public function getUrlAttribute() {
        return url('trades/listings/'.$this->id);
    }

    /**********************************************************************************************

        OTHER FUNCTIONS

    **********************************************************************************************/

    /**
     * Gets all characters involved in the trade listing.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCharacterData() {
        return Character::with('user')->whereIn('id', $this->getCharacters($this->user))->get();
    }

    /**
     * Gets the inventory of the user for selection.
     *
     * @param mixed $user
     *
     * @return array
     */
    public function getInventory($user) {
        return $this->data && isset($this->data['user']['user_items']) ? $this->data['user']['user_items'] : [];

        return $inventory;
    }

    /**
     * Gets the currencies of the given user for selection.
     *
     * @param User $user
     *
     * @return array
     */
    public function getCurrencies($user) {
        return $this->data && isset($this->data['user']) && isset($this->data['user']['currencies']) ? $this->data['user']['currencies'] : [];
    }

    /**
     * Gets the characters of the given user for selection.
     *
     * @param User $user
     *
     * @return array
     */
    public function getCharacters($user) {
        $characters = $this->data && isset($this->data['user']) && isset($this->data['user']['characters']) ? $this->data['user']['characters'] : [];
        if ($characters) {
            $characters = array_keys($characters);
        }

        return $characters;
    }
}
