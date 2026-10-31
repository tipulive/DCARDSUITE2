<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\promotion
 *
 * @property int $id
 * @property string $uid
 * @property string $uidCreator
 * @property string $subscriber
 * @property string $token
 * @property string $promoName
 * @property string|null $promoschema
 * @property string $promo_msg
 * @property string $reach
 * @property string $gain
 * @property string $type_service
 * @property string $started_date
 * @property string|null $ended_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|promotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|promotion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|promotion query()
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereEndedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereGain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion wherePromoMsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion wherePromoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion wherePromoschema($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereReach($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereStartedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereTypeService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|promotion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class promotion extends Model
{
    use HasFactory;
}
