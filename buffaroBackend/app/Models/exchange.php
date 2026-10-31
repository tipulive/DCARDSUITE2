<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\exchange
 *
 * @property int $id
 * @property string $currency
 * @property string $currencyV
 * @property string $currencyF
 * @property string $subscriber
 * @property string $uidCreator
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|exchange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|exchange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|exchange query()
 * @method static \Illuminate\Database\Eloquent\Builder|exchange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|exchange whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|exchange whereCurrencyF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|exchange whereCurrencyV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|exchange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|exchange whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|exchange whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|exchange whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class exchange extends Model
{
    use HasFactory;
}
