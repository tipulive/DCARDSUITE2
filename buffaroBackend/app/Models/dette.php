<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\dette
 *
 * @property int $id
 * @property string $uid
 * @property string $uidUser
 * @property string $uidCreator
 * @property string $amount
 * @property string $paidAmount
 * @property string $status
 * @property mixed|null $temporalData
 * @property string $systemUid
 * @property string $subscriber
 * @property string $purpose
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|dette newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|dette newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|dette query()
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereTemporalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereUidUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|dette whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class dette extends Model
{
    use HasFactory;
}
