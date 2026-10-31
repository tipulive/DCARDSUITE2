<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\safProductlose
 *
 * @property int $id
 * @property string $SafariId
 * @property string $productCode
 * @property string $subscriber
 * @property string $order_creator
 * @property string $price
 * @property string $qty
 * @property string $qty_count
 * @property string $total
 * @property string $status
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose query()
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereOrderCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereQtyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereSafariId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safProductlose whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class safProductlose extends Model
{
    use HasFactory;
}
