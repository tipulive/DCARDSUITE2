<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\topup
 *
 * @property int $id
 * @property string $uid
 * @property string $uidCreator
 * @property string $balance
 * @property string $bonus
 * @property string $CBalance
 * @property string $CBonus
 * @property string $subscriber
 * @property string $purpose
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|topup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|topup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|topup query()
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereCBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereCBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class topup extends Model
{
    use HasFactory;
}
