<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $uid
 * @property string $uidCreator
 * @property string $AdminRecord_Status
 * @property string $CompanyName
 * @property string $photo_url
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $Ccode
 * @property string $phone
 * @property string $PhoneNumber
 * @property string $initCountry
 * @property string $platform
 * @property string $status
 * @property string $subscriber
 * @property string|null $permission
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereAdminRecordStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereInitCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUidCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    //
     //
     use Notifiable, HasApiTokens;

     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */

     protected $guard ='Admin';
     protected $fillable = [
         'name', 'email','PhoneNumber', 'password','userid','platform'
     ];

     /**
      * The attributes that should be hidden for arrays.
      *
      * @var array
      */
     protected $hidden = [
         'password', 'remember_token',
     ];

     /**
      * The attributes that should be cast to native types.
      *
      * @var array
      */
     protected $casts = [
         'email_verified_at' => 'datetime',
     ];
}
