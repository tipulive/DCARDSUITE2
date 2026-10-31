<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\deliver
 *
 * @property int $id
 * @property string $uid
 * @property string $productCode
 * @property string $uidTransport
 * @property string $qty_Transport
 * @property string $StockName
 * @property string $stockDeliver
 * @property string|null $commentData
 * @property string $subscriber
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|deliver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|deliver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|deliver query()
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereQtyTransport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereStockDeliver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereStockName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereUidTransport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|deliver whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class deliver extends Model
{
    use HasFactory;
}
