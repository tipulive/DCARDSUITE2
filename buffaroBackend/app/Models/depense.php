<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\depense
 *
 * @property int $id
 * @property string $uid
 * @property string $safariId
 * @property string $uidUser
 * @property string $uidCreator
 * @property string $amount
 * @property string $status
 * @property string $subscriber
 * @property mixed|null $temporalData
 * @property string $systemUid
 * @property string $purpose
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|depense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|depense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|depense query()
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereSafariId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereTemporalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereUidUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|depense whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class depense extends Model
{
    use HasFactory;
}
