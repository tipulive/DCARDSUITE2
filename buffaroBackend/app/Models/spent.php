<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\spent
 *
 * @property int $id
 * @property string $safariuid
 * @property string $price
 * @property string|null $comment
 * @property string $uidCreator
 * @property string $subscriber
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|spent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|spent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|spent query()
 * @method static \Illuminate\Database\Eloquent\Builder|spent whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|spent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|spent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|spent wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|spent whereSafariuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|spent whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|spent whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|spent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class spent extends Model
{
    use HasFactory;
}
