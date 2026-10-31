<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\quickbonus
 *
 * @property int $id
 * @property string $quickUid
 * @property string $productName
 * @property string $qty
 * @property string $price
 * @property string $status
 * @property string $bonusType
 * @property string $giftName
 * @property string $giftValues
 * @property string $giftPerPcs
 * @property string $giftMin
 * @property string $moneyMin
 * @property string $bonusValue
 * @property string $uidCreator
 * @property string $subscriber
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus query()
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereBonusType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereBonusValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereGiftMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereGiftName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereGiftPerPcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereGiftValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereMoneyMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereQuickUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbonus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class quickbonus extends Model
{
    use HasFactory;
}
