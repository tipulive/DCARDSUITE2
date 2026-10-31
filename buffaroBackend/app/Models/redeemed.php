<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\redeemed
 *
 * @property int $id
 * @property string $uid
 * @property string $uidCreator
 * @property string $status
 * @property string $balance
 * @property string $bonus
 * @property string $CBalance
 * @property string $CBonus
 * @property string $subscriber
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed query()
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereCBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereCBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|redeemed whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class redeemed extends Model
{
    use HasFactory;
}
