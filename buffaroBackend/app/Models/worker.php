<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\worker
 *
 * @property int $id
 * @property string $uidUser
 * @property string $uidCreator
 * @property string $amount
 * @property string $position
 * @property string $systemUid
 * @property string $jobContract
 * @property mixed|null $temporalData
 * @property string $started_at
 * @property string $datePaid_at
 * @property string $paid_at
 * @property string $status
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|worker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|worker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|worker query()
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereDatePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereJobContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereTemporalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereUidUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|worker whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class worker extends Model
{
    use HasFactory;
}
