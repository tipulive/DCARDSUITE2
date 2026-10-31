<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\reqStock
 *
 * @property int $id
 * @property string $uid
 * @property string $productCode
 * @property string $price
 * @property string $qty
 * @property string $uidSender
 * @property string $status
 * @property string $subscriber
 * @property string $uidReceiver
 * @property string $recSubscriber
 * @property string $uidCancel
 * @property string|null $cancelDate
 * @property string $productName
 * @property string $img_url
 * @property string $pcs
 * @property string|null $commentData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock query()
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereCancelDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereCommentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock wherePcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereRecSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereUidCancel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereUidReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereUidSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|reqStock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class reqStock extends Model
{
    use HasFactory;
}
