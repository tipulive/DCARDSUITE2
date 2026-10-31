<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\testdata
 *
 * @property int $id
 * @property string $name
 * @property mixed|null $json_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|testdata newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|testdata newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|testdata query()
 * @method static \Illuminate\Database\Eloquent\Builder|testdata whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|testdata whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|testdata whereJsonColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|testdata whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|testdata whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class testdata extends Model
{
    use HasFactory;
}
