<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\participatedHist
 *
 * @property int $id
 * @property string $uid
 * @property string $uidUser
 * @property string $uidCreator
 * @property string $carduid
 * @property string $subscriber
 * @property string $promotion_msg
 * @property string $inputData
 * @property string $actionName
 * @property string $token
 * @property string $started_date
 * @property string $ended_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist query()
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereActionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereCarduid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereEndedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereInputData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist wherePromotionMsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereStartedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereUidUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|participatedHist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class participatedHist extends Model
{
    use HasFactory;
}
