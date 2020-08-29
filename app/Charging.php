<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int load
 * @property int shift
 */
class Charging extends Model
{
    /**
     * @return BelongsTo
     */
    public function battery(): BelongsTo
    {
        return $this->belongsTo(Battery::class);
    }

    public function setShiftAttributeManual(int $batteryId): void
    {
        $lastCharge = self::where('battery_id', $batteryId)
        ->orderBy('id', 'desc')
        ->first();

        $this->shift = $this->load - $lastCharge->load;
    }
}
