<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\participated
 *
 * @property int $id
 * @property string $uid
 * @property string $uidUser
 * @property string $carduid
 * @property string $uidCreator
 * @property string $subscriber
 * @property string $promotion_msg
 * @property string $inputData
 * @property string $token
 * @property string $started_date
 * @property string $ended_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|participated newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|participated newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|participated query()
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereCarduid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereEndedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereInputData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated wherePromotionMsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereStartedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereUidUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participated whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class participated extends Model
{
    use HasFactory;
}
