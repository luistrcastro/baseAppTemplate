<?php

namespace App\Models;

use App\Scopes\AuthUserScope;
use App\Services\HashableService;
use App\Traits\HashedId;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    use HasFactory;
    use HashedId;

    public $table = 'accounts';

    /**
     * Overrides the model's booted method
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new AuthUserScope);

        static::creating(function ($query) {
            $query->user_id = Auth::user()->getKey();
        });
    }

    public $fillable = [
        'user_id',
        'label',
        'description',
        'last_four',
        'institution',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'label' => 'string',
        'description' => 'string',
        'last_four' => 'integer',
        'institution' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var string[]
     */
    public static array $createRules = [
        'label' => 'string',
        'description' => 'nullable|string',
        'last_four' => 'nullable|integer',
        'institution' => 'nullable|string',
    ];

    public static array $updateRules = [
        'label' => 'string',
        'description' => 'nullable|string',
        'last_four' => 'nullable|integer',
        'institution' => 'nullable|string',
    ];

    /**---------------------
     * - Relationships:
     * ---------------------**/
    public const relations = ['user'];

    /**
     * Get the user the transaction belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**---------------------
     * - Accessors and Mutators:
     * ---------------------**/

    public function userId(): Attribute
    {
        return Attribute::get(fn($value)=> HashableService::getHash($value, 'User'));
    }
}
