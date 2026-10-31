<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\workerPayment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|workerPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|workerPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|workerPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|workerPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|workerPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|workerPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class workerPayment extends Model
{
    use HasFactory;
}
