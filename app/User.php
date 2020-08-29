<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function batteries(): HasMany
    {
        return $this->hasMany(Battery::class);
    }

    /**
     * @return Collection
     */
    public function orderedBatteries(): Collection
    {
        return $this->batteries()
            ->orderByDesc(
                Charging::select('load')
                    ->whereColumn('batteries.id', 'chargings.battery_id')
                    ->limit(1)
            )
            ->orderBy(
                Charging::select('created_at')
                    ->whereColumn('batteries.id', 'chargings.battery_id')
                    ->latest()
                    ->limit(1)
            )
            ->get();
    }
}
