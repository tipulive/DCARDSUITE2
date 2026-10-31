<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\quickbosubmit
 *
 * @property int $id
 * @property string $uid
 * @property string $quickUid
 * @property string $uidUser
 * @property string $productName
 * @property string $qty
 * @property string $price
 * @property string $total
 * @property string $status
 * @property string $bonusType
 * @property string $giftName
 * @property string $giftPcs
 * @property string $bonusValue
 * @property string $totBonusValue
 * @property string $uidCreator
 * @property string $subscriber
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit query()
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereBonusType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereBonusValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereGiftName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereGiftPcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereQuickUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereTotBonusValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereUidUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quickbosubmit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class quickbosubmit extends Model
{
    use HasFactory;
}
