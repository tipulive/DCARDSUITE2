<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\tempTable
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property string $uidCreator
 * @property mixed|null $tempData
 * @property string $status
 * @property string $subscriber
 * @property string $actionTable
 * @property string $systemUid
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable query()
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereActionTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereTempData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|tempTable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class tempTable extends Model
{
    use HasFactory;
}
