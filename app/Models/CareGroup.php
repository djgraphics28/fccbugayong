<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareGroup extends Model
{
    protected $guarded = [];

    /**
     * Get all of the members for the CareGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members(): HasMany
    {
        return $this->hasMany(CareGroupMember::class, 'care_group_id', 'id');
    }

    /**
     * Get the mentor that owns the CareGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'mentor_id', 'id');
    }

    /**
     * Get the leader that owns the CareGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'leader_id', 'id');
    }
}
