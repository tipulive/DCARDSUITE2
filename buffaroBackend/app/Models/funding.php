<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\funding
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|funding newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|funding newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|funding query()
 * @method static \Illuminate\Database\Eloquent\Builder|funding whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|funding whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|funding whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class funding extends Model
{
    use HasFactory;
}
