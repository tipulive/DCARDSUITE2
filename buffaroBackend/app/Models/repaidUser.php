<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\repaidUser
 *
 * @property int $id
 * @property string $uid
 * @property string $uidPaid
 * @property string $uidReceiver
 * @property string $amount
 * @property string $status
 * @property string $subscriber
 * @property string $systemUid
 * @property string $signature
 * @property string $purpose
 * @property mixed|null $temporalData
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $receiverComment
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereReceiverComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereTemporalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereUidPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereUidReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class repaidUser extends Model
{
    use HasFactory;
}
