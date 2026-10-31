<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\topupHistory
 *
 * @property int $id
 * @property string $uid
 * @property string $uidCreator
 * @property string $amount
 * @property string $action
 * @property string $balance
 * @property string $bonus
 * @property string $CBalance
 * @property string $CBonus
 * @property string $subscriber
 * @property string $systemUid
 * @property string $purpose
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereCBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereCBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|topupHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class topupHistory extends Model
{
    use HasFactory;
}
