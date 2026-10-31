<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SyncOn
 *
 * @property int $id
 * @property string $uid
 * @property string $versionCount
 * @property string $subscriber
 * @property string $actionName
 * @property string $tableName
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn query()
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn whereActionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn whereTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SyncOn whereVersionCount($value)
 * @mixin \Eloquent
 */
class SyncOn extends Model
{
    use HasFactory;
}
