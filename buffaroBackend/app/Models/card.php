<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\card
 *
 * @property int $id
 * @property string $uid
 * @property string $CardNumber
 * @property string $uidCreator
 * @property string $uidUploader
 * @property string $subscriber
 * @property string $filename
 * @property string $status
 * @property string $SyncAdd
 * @property string $SyncUpdate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|card query()
 * @method static \Illuminate\Database\Eloquent\Builder|card whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereSyncAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereSyncUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereUidUploader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|card whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class card extends Model
{
    use HasFactory;
}
