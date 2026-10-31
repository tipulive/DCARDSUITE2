<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\order
 *
 * @property int $id
 * @property string $uid
 * @property string $uidUser
 * @property string $uidCreator
 * @property string $subscriber
 * @property string $total
 * @property string $paid
 * @property string $debt
 * @property string $paidStatus
 * @property string $Status
 * @property mixed|null $temporalData
 * @property string $systemUid
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $promotionUid
 * @property string $reach
 * @property string $gain
 * @method static \Illuminate\Database\Eloquent\Builder|order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|order query()
 * @method static \Illuminate\Database\Eloquent\Builder|order whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereDebt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereGain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order wherePaidStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order wherePromotionUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereReach($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereTemporalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereUidUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class order extends Model
{
    use HasFactory;
}
