<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\safari
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property string|null $comment
 * @property string $uidCreator
 * @property string $subscriber
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|safari newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|safari newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|safari query()
 * @method static \Illuminate\Database\Eloquent\Builder|safari whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safari whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safari whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safari whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safari whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safari whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safari whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safari whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class safari extends Model
{
    use HasFactory;
}
