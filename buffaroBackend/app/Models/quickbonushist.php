<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\quickbonushist
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonushist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonushist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonushist query()
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonushist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonushist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonushist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class quickbonushist extends Model
{
    use HasFactory;
}
