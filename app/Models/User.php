<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /** @var bool */
    public $incrementing = false;

    /** * @var string */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone_number',
        'birth_date',
        'document_id',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public static array $createRules = [
        'name' => [
            'required',
            'max:255',
        ],
        'email' => [
            'required',
            'max:255',
            'email',
            'unique:App\Models\User,email',
        ],
        'password' => [
            'required',
            'confirmed',
        ],
        'phone_number' => ['required'],
        'birth_date' => [
            'required',
            'date',
        ],
        'document_id' => [
            'required',
            'regex:/([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/',
            'unique:App\Models\User,document_id',
        ],
    ];

    public static array $updateRules = [
        'name' => [
            'required',
            'max:255',
        ],
        'email' => [
            'required',
            'max:255',
            'email',
//            'unique:users,email', TODO Verify if it's unique except for the current user
        ],
        'phone_number' => ['required'],
        'birth_date' => [
            'required',
            'date',
        ],
    ];
}
