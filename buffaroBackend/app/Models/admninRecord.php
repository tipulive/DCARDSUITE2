<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\admninRecord
 *
 * @property int $id
 * @property string $uid
 * @property string $balance sold sales z
 * ose habariwemo na promotions ya items ndetse namadeni
 * @property string $balanceSent
 * @property string $bonus
 * @property string $dettes
 * @property string $safeBalance
 * @property string $borrowBalance
 * @property string $status
 * @property string $systemUid
 * @property string $addBalance
 * @property string $subscriber
 * @property string $currentAction
 * @property string $spend all spending exclude bonus
 * @property string $promoAmount Long aya ni amafaranga gusa ariko admin aba atarayitanga, aha urugero nzatanga promo 25$
 * @property string $promoAsset Long ni amafaranga yibyo mwatanze biri physic kuri promotion urugero simba, castel Total:4000 ubwo 4000 niyo promoAsset hano admin aba atarayitanga
 * @property string $proAssetQty Long ni qty ziri physic zibyo baba bateganya gutanga muri promotion
 * @property string $outPromoAmount Quick or Long aya namafaranga admin aba amaze gutanga ya promotion
 * @property string $outPromoAsset Quick or Long ni amafaranga yibyo mwatanze biri physic kuri promotion hano admin aba yabitanze
 * @property string $outProAssetQty Quick or Long ni qty ziri physic admin aba yaratanze muri promo
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereAddBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereBalanceSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereBorrowBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereCurrentAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereDettes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereOutProAssetQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereOutPromoAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereOutPromoAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereProAssetQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord wherePromoAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord wherePromoAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereSafeBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereSpend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereSystemUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|admninRecord whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class admninRecord extends Model
{
    use HasFactory;
}
