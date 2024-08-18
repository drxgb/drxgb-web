<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Override;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
		'display_name',
        'email',
        'password',
		'language_id',
		'profile_photo_path',
		'role_id',
		'provider',
		'provider_id',
    ];

    /**
	 * The attributes that should be hidden for serialization.
     *
	 * @var array<int, string>
     */
	protected $hidden = [
		'password',
        'remember_token',
		'provider_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
		'show_name',
    ];

	/**
     * Receber a URL da foto do perfil de usuário.
	 *
     * @return Attribute
     */
	#[Override]
    public function profilePhotoUrl() : Attribute
    {
        return Attribute::get(function (): string
		{
			if ($this->profile_photo_path)
			{
				/** @var Cloud */
				$disk = Storage::disk($this->profilePhotoDisk());

				return filter_var($this->profile_photo_path, FILTER_VALIDATE_URL)
					? $this->profile_photo_path
					: $disk->url($this->profile_photo_path);
			}

            return $this->defaultProfilePhotoUrl();
        });
    }


	/**
	 * Mostra o nome de exibição ou o nome de usuário, caso contrário.
	 *
	 * @return Attribute
	 */
	public function showName() : Attribute
	{
		return Attribute::get(fn (): string => $this->display_name ?: $this->name);
	}


	/**
	 * Recebe o idioma do usuário.
	 *
	 * @return BelongsTo
	 */
	public function language() : BelongsTo
	{
		return $this->belongsTo(Language::class);
	}


	/**
	 * Recebe o cargo do usuário.
	 *
	 * @return BelongsTo
	 */
	public function role() : BelongsTo
	{
		return $this->belongsTo(Role::class);
	}


	/**
	 * Verifica se o usuário é um administrador.
	 *
	 * @return bool
	 */
	public function isAdmin() : bool
	{
		return $this->role_id === 1;
	}
}
