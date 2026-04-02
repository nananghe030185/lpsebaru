<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Fortify\TwoFactorAuthenticatable;
// use Laravel\Jetstream\HasProfilePhoto;
// use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    // use HasProfilePhoto;
    // use HasTeams;
    use Notifiable;
    // use TwoFactorAuthenticatable;
    use HasRoles;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'role',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'masa_berlaku' => 'datetime',
            'password' => 'hashed',
            'notif_email_tender' => 'boolean',
            'notif_email_lelang' => 'boolean',
            'notif_whatsapp_tender' => 'boolean',
            'notif_whatsapp_lelang' => 'boolean',
            'notif_telegram_tender' => 'boolean',
            'notif_telegram_lelang' => 'boolean',
            
        ];
    }

    protected $with = [
        'media',
        'grup',
    ];

    public static function booted()
    {
        parent::boot();
        static::saving(function ($model) {
            // $model->created_by_id = \App\Helpers\Helpers::isUserLogin() ? \App\Helpers\Helpers::getCurrentUserId() : $model->id;
        });
    }

    /**
     * Get the user's role.
     */
    public function getRoleAttribute()
    {
        return $this->roles->first()?->makeHidden(['created_at', 'updated_at', 'pivot']);
    }

    /**
     * Get the user's all permissions.
     */
    public function getPermissionAttribute()
    {
        return $this->getAllPermissions();
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->getFirstMediaUrl('profile_photo') ?: asset('images/default-profile.png');
    }

    public function grup() : BelongsTo
    {
        return $this->belongsTo(Groups::class, 'group_id');
    }
}
