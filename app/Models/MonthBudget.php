<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashedId;
use App\Scopes\AuthUserScope;
use App\Services\HashableService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class MonthBudget extends Model
{
    use HasFactory;
    use HashedId;
    use SoftDeletes;

    public $table = 'month_budgets';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

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
      'name',
      'color',
      'icon',
      'description',
      'percentage'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
      'user_id' => 'integer',
      'name' => 'string',
      'color' => 'string',
      'icon' => 'string',
      'description' => 'string',
      'percentage' => 'decimal:2',
      'type' => 'string'
    ];

    /**
     * Validation rules.
     *
     * @var string[]
     */
    public static array $createRules = [
      'name' => 'required|string|max:25',
      'color' => 'required|string|max:25',
      'icon' => 'required|string|max:25',
      'description' => 'nullable|string|max:255',
      'percentage' => 'nullable|decimal',
      'type' => 'required|in:income,expense'
    ];
    
    public static array $updateRules = [
      'name' => 'required|string|max:25',
      'color' => 'required|string|max:25',
      'icon' => 'required|string|max:25',
      'description' => 'nullable|string|max:255',
      'percentage' => 'nullable|decimal',
      'type' => 'required|in:income,expense'
    ];

    /**---------------------
     * - Relationships:
     * ---------------------**/
    public const relations = ['user'];

    /**
     * Get the user the category belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**---------------------
    * - Accessors and Mutators:
    * ---------------------**/

    public function userId(): Attribute
    {
        return Attribute::get(fn($value)=> HashableService::getHash($value, 'User'));
    }
}
