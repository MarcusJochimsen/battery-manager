<?php

namespace App;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed id
 */
class Battery extends Model
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function chargings(): HasMany
    {
        return $this->hasMany(Charging::class);
    }

    /**
     * @return int
     */
    public function charged(): int
    {
        return $this->chargings()->where('shift', '>', 0)->count();
    }

    /**
     * @return int
     */
    public function chargeCycles(): string
    {
        return number_format(
            $this->chargings()->where('shift', '>', 0)->sum('shift') / 100,
            1,
            ',',
            '.'
        );
    }

    /**
     * @return int
     */
    public function actualLoad(): int
    {
        return $this->chargings()->orderByDesc('id')->first()->load;
    }

    /**
     * @return Carbon
     * @throws Exception
     */
    public function lastChargingChange(): Carbon
    {
        return new Carbon($this->chargings()->orderByDesc('id')->first()->created_at);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function lastChargingChangeHuman(): string
    {
        return $this->lastChargingChange()->isoFormat('LL');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function lastChargingChangeHumanDiff(): string
    {
        return $this->lastChargingChange()->diffForHumans();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function lastChargingChangeStatus(): string
    {
        $daysSinceLastChargingChange = $this->lastChargingChange()->diffInDays();
        $actualLoad = $this->actualLoad();

        if ($actualLoad < 90) {
            return 'd-none';
        }

        if ($daysSinceLastChargingChange >= 14) {
            return 'text-danger';
        }

        if ($daysSinceLastChargingChange >= 7) {
            return 'text-warning';
        }

        return 'd-none';
    }

    /**
     * @return string
     */
    public function chargingStatusColor(): string
    {
        $actualLoad = $this->actualLoad();

        if ($actualLoad >= 90) {
            return 'bg-success';
        }

        if ($actualLoad < 40) {
            return 'bg-danger';
        }

        return 'bg-warning';
    }
}
