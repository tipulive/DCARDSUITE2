<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\miniAccount
 *
 * @property int $id
 * @property string $uidOwner
 * @property string $ownerSubscriber
 * @property string $miniOwner
 * @property string $miniOwnerSubscriber
 * @property string $uidCreator
 * @property string $addedStatus
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount whereAddedStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount whereMiniOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount whereMiniOwnerSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount whereOwnerSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount whereUidOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|miniAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class miniAccount extends Model
{
    use HasFactory;
}
