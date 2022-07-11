<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes,
};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    /** @var bool */
    public $incrementing = false;

    /** * @var string */
    protected $keyType = 'string';

    /** @var string */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'zip',
        'uf',
        'city',
        'street',
        'number',
        'neighborhood',
        'complement',
        'user_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static array $createRules = [
        'zip' => [
            'required',
            'regex:(^[0-9]{5}-?[0-9]{3}$)',
        ],
        'uf' => [
            'required',
//            'digits:2',
        ],
        'city' => ['required'],
        'street' => ['required'],
        'number' => ['nullable'],
        'neighborhood' => ['nullable'],
        'complement' => ['nullable'],
    ];

    public static array $updateRules = [
        'zip' => [
            'required',
            'regex:(^[0-9]{5}-?[0-9]{3}$)',
        ],
        'uf' => [
            'required',
//            'digits:2',
        ],
        'city' => ['required'],
        'street' => ['required'],
        'number' => ['nullable'],
        'neighborhood' => ['required'],
        'complement' => ['nullable'],
    ];
}
