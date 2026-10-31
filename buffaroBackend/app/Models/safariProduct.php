<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\safariProduct
 *
 * @property int $id
 * @property string $uid
 * @property string $safariuid
 * @property string $price
 * @property string $SoldInterest
 * @property string $currency
 * @property string $exchangeRate
 * @property string $typeData
 * @property string $status
 * @property string $qty
 * @property string $pcs
 * @property string $size
 * @property string|null $comment
 * @property string $uidCreator
 * @property string $subscriber
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct wherePcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereSafariuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereSoldInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereTypeData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|safariProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class safariProduct extends Model
{
    use HasFactory;
}
