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

class Transaction extends Model
{
    use HasFactory;
    use HashedId;

    public $table = 'transactions';

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
      'category_id',
      'account_id',
        'parent_transaction_id',
        'budget_id',
        'description',
        'value',
        'date',
        'is_computed',
        'duplication_checked',
        'system_generated'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
      'account_id' => 'integer',
        'user_id' => 'integer',
        'parent_transaction_id' => 'integer',
        'budget_id' => 'integer',
        'category_id' => 'integer',
        'description' => 'string',
        'value' => 'decimal:2',
        'date' => 'date:Y-m-d',
        'is_computed' => 'boolean',
        'duplication_checked' => 'boolean',
        'system_generated' => 'boolean',
    ];

    /**
     * Validation rules.
     *
     * @var string[]
     */
    public static array $createRules = [
      'account_id' => 'required|integer',
        'parent_transaction_id' => 'nullable|integer',
        'category_id' => 'nullable|integer|exists:category,id',
        'budget_id' => 'nullable|integer|exists:budget,id',
        'description' => 'required|string|max:255',
        'value' => 'required|numeric',
        'date' => 'required|date',
        'is_computed' => 'boolean',
        'duplication_checked' => 'boolean',
        'system_generated' => 'boolean'
    ];

    public static array $updateRules = [
      'account_id'=>'required|integer',
        'category_id' => 'nullable|integer|exists:category,id',
        'budget_id' => 'nullable|integer|exists:budget,id',
        'description' => 'required|string|max:255',
        'value' => 'required|numeric',
        'date' => 'required|date',
        'is_computed' => 'boolean',
        'duplication_checked' => 'boolean',
    ];

    /**---------------------
     * - Relationships:
     * ---------------------**/
    public const relations = ['user', 'category', 'budget'];

    /**
     * Get the user the transaction belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category the transaction belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function budget(): BelongsTo
    {
      return $this->belongsTo(Budget::class, 'budget_id');
    }

    /**---------------------
     * - Accessors and Mutators:
     * ---------------------**/

    public function userId(): Attribute
    {
        return Attribute::get(fn($value)=> HashableService::getHash($value, 'User'));
    }

    public function categoryId(): Attribute
    {
        return new Attribute(
            get: fn ($value) => HashableService::getHash($value, 'Category'),
            set: fn ($value) => HashableService::decodeHash($value, 'Category'),
        );
    }
}
