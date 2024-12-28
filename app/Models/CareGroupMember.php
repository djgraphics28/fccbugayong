<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareGroupMember extends Model
{
    protected $guarded = [];

    /**
     * Get the care_group that owns the CareGroupMember
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function care_group(): BelongsTo
    {
        return $this->belongsTo(CareGroup::class, 'care_group_id', 'id');
    }

    /**
     * Get the member that owns the CareGroupMember
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
