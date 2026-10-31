<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SyncOff
 *
 * @property int $id
 * @property string $uid
 * @property string $versionCount
 * @property string $subscriber
 * @property string $actionName
 * @property string $tableName
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff query()
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff whereActionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff whereTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOff whereVersionCount($value)
 * @mixin \Eloquent
 */
class SyncOff extends Model
{
    use HasFactory;
}
