<?php

namespace App;

use App\Traits\UserSettingsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use UserSettingsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'level', 'ref'
    ];
    protected $appends = ['avatar', 'getroles', 'parent', 'refuser', 'telegram', 'currency', 'language'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function getAvatarAttribute()
    {
        $path = Storage::exists('/public/users/' . $this->id . '.jpg');
        $avatar = ($path) ? asset('storage/users/' . $this->id . '.jpg') : asset('storage/users/0.jpg');
        return $avatar;
    }
    /* 0 root , 1 agent , 2 grand , 3 rest , 4 operator */


    public function getRefuserAttribute()
    {
        if ($this->ref == 0) {
            return false;
        }
        return User::find($this->ref);
    }
    public function getParentAttribute()
    {
        $parents = [
            'sup' => 0,
            'grand' => 0,
            'rest' => 0,
            'agent' => 0
        ];
        if ($this->level == 4) {
            $parents['agent'] = $this->id;
            $rest = User::findOrFail($this->ref);
            $parents['rest'] = $rest->id;
            if ($rest->ref != 0) {
                $rest_ref = User::findOrFail($rest->ref);
                if ($rest_ref->level == 2) {
                    $parents['grand'] = $rest_ref->id;
                    if ($rest_ref->ref != 0) {
                        $grand_ref = User::findOrFail($rest_ref->ref);
                        if ($grand_ref->level == 1) {
                            $parents['sup'] = $grand_ref->id;
                        }
                    }
                } elseif ($rest_ref->level == 1) {
                    $parents['sup'] = $rest_ref->id;
                }
            }
        }
        if ($this->level == 3) {
            $parents['rest'] = $this->id;
            if ($this->ref != 0) {
                $rest_ref = User::findOrFail($this->ref);

                if ($rest_ref->level == 2) {
                    $parents['grand'] = $rest_ref->id;
                    if ($rest_ref->ref != 0) {
                        $grand_ref = User::findOrFail($rest_ref->ref);
                        if ($grand_ref->level == 1) {
                            $parents['sup'] = $grand_ref->id;
                        }
                    }
                } elseif ($rest_ref->level == 1) {
                    $parents['sup'] = $rest_ref->id;
                }
            }
        }
        if ($this->level == 2) {
            $parents['grand'] = $this->id;
            if ($this->ref != 0) {
                $grand_ref = User::findOrFail($this->ref);
                if ($grand_ref->level == 1) {
                    $parents['sup'] = $grand_ref->id;
                }
            }
        }
        if ($this->level == 1) {
            $parents['sup'] = $this->id;
        }
        return $parents;
    }

    public function getLogoAttribute()
    {
        $path = Storage::exists('/public/users/' . $this->id . '.jpg');
        $avatar = ($path) ? '/storage/users/' . $this->id . '.jpg' : '/storage/users/0.jpg';
        return $avatar;
    }

    public function getTelegramAttribute()
    {
        return (is_object($this->getSetting('telegram'))) ? $this->getSetting('telegram')->value : null;
    }
    public function getCurrencyAttribute()
    {
        return (is_object($this->getSetting('currency'))) ? $this->getSetting('currency')->value : null;
    }
    public function getLanguageAttribute()
    {
        return (is_object($this->getSetting('language'))) ? $this->getSetting('language')->value : 'tr';
    }

    public function getGetrolesAttribute()
    {
        return $this->roles;
    }


    public function getTokenAttribute()
    {

        return Str::random(60);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
}