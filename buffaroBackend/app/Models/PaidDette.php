<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaidDette
 *
 * @property int $id
 * @property string $uid
 * @property string $uidUser
 * @property string $uidReceiver
 * @property string $uidCreator
 * @property string $amount
 * @property string $safeAmount
 * @property string $paidStatus
 * @property string $status
 * @property mixed|null $temporalData
 * @property string $signature
 * @property string $systemUid
 * @property string $subscriber
 * @property string $purpose
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $tot_paid
 * @property string $paid_id
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette wherePaidId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette wherePaidStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereSafeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereTemporalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereTotPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereUidReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereUidUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaidDette whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaidDette extends Model
{
    use HasFactory;
}
