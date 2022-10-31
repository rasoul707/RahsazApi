<?php

namespace Modules\User\Entities;

use App\Models\TimeHelper;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Modules\Cart\Entities\Cart;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const TYPES = [
        'مدیر اصلی' => 'مدیر اصلی',
        'مدیر' => 'مدیر',
        'مشتری' => 'مشتری',
    ];

    const ROLES = [
        'همکار' => 'همکار',
        'شرکت' => 'شرکت',
        'مشتری' => 'مشتری',
    ];

    const STATUSES = [
        'در انتظار تایید مدیریت' => 'در انتظار تایید مدیریت',
        'فعال' => 'فعال',
        'غیر فعال' => 'غیر فعال',
    ];

    const PACKAGES = [
        'طلایی' => 'طلایی',
        'نقره ای' => 'نقره ای',
        'برنزی' => 'برنزی',
    ];

    const IRAN_PHONE_NUMBER_REGEX = "/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/";


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'temporary_sms_code'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)
            ->orWhere('phone_number', $identifier)
            ->first();
    }


    /* Scopes */

    public function scopeIsSubAdmin($query)
    {
        return $query->where('type', User::TYPES['مدیر']);
    }

    public function scopeOnline($query)
    {
        return $query->where('last_seen_at', '>', Carbon::now()->subMinutes(5));
    }

    public function scopeOnlineToday($query)
    {
        return $query->where('last_seen_at', '>', Carbon::now()->startOfDay());
    }

    public function scopeOnlineYesterday($query)
    {
        return $query->whereBetween('last_seen_at', [Carbon::now()->subDay()->startOfDay(), Carbon::now()->subDay()->endOfDay()]);
    }

    public function scopeOnlineThisMonth($query)
    {
        return $query->where('last_seen_at', '>', Carbon::now()->subMonth());
    }

    /* Relations */

    public function package()
    {
        return $this->belongsTo(UserPackage::class)->select('id', 'title');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function routeNotificationForFarazSMS($notifiable)
    {
        return $this->phone_number;
    }

    /* Mutators */

    public function getBirthdayAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return (new Verta($value))->formatDatetime();
    }

    /* Methods */

    public static function updateOrCreateCustomer(User $user, $request)
    {
        $user->type = User::TYPES['مشتری'];
        $user->status = $request->status;
        $user->package = $request->package;
        $user->role = $request->role;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->address = $request->address;
        if ($request->birthday) {
            $user->birthday = TimeHelper::jalali2georgian($request->birthday);
        }
        $user->legal_info_melli_code = $request->legal_info_melli_code;
        $user->legal_info_economical_code = $request->legal_info_economical_code;
        $user->legal_info_registration_number = $request->legal_info_registration_number;
        $user->legal_info_company_name = $request->legal_info_company_name;
        $user->legal_info_state = $request->legal_info_state;
        $user->legal_info_city = $request->legal_info_city;
        $user->legal_info_address = $request->legal_info_address;
        $user->legal_info_phone_number = $request->legal_info_phone_number;
        $user->legal_info_postal_code = $request->legal_info_postal_code;
        $user->refund_info_bank_name = $request->refund_info_bank_name;
        $user->refund_info_account_holder_name = $request->refund_info_account_holder_name;
        $user->refund_info_cart_number = $request->refund_info_cart_number;
        $user->refund_info_account_number = $request->refund_info_account_number;
        $user->refund_info_sheba_number = $request->refund_info_sheba_number;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->guild_identifier = $request->guild_identifier;
        $user->store_name = $request->store_name;
    }

    public static function firstOrCreateCart(User $user)
    {
        $cart =  Cart::query()->where('user_id', $user->id)->first();
        if ($cart) {
            return $cart;
        }

        return Cart::query()
            ->create([
                'user_id' => $user->id,
            ]);
    }

    public static function setUserPermissions(User $user, $request)
    {
        UserPermission::query()
            ->where('user_id', $user->id)
            ->delete();
        $permissions = Permission::query()->get();
        foreach ($permissions as $permission) {
            if ($request[$permission->tag_id_en]) {
                UserPermission::query()
                    ->create([
                        'user_id' => $user->id,
                        'permission_id' => $permission->id,
                    ]);
            }
        }
    }
}
