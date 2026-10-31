<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\repaidAdmin
 *
 * @property int $id
 * @property string $uid
 * @property string $uidPaid
 * @property string $amount
 * @property string $subscriber
 * @property string $status
 * @property string $intermediary_id uwo bahereye receiver amafaranga yiwe
 * @property string|null $interDate
 * @property string $uidReceiver
 * @property string|null $cancelDate
 * @property string $uidCancel
 * @property string $purpose
 * @property string $systemUid
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereCancelDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereInterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereIntermediaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereUidCancel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereUidPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereUidReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|repaidAdmin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class repaidAdmin extends Model
{
    use HasFactory;
}
