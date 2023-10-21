<?php

namespace App\Models;

use App\Scopes\AuthUserScope;
use App\Services\HashableService;
use App\Traits\HashedId;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Category extends Model
{
    use HasFactory;
    use HashedId;
    use SoftDeletes;

    public $table = 'categories';

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
        'parent_category_id',
        'name',
        'slug',
        'color',
        'icon',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'parent_category_id' => 'integer',
        'month_budget_id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'color' => 'string',
        'icon' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules.
     *
     * @var string[]
     */
    public static array $createRules = [
        'parent_category_id' => 'nullable|integer',
        'month_budget_id' => 'nullable|integer',
        'name' => 'required|string|max:25',
        'slug' => 'required|string|max:25',
        'color' => 'required|string|max:25',
        'icon' => 'required|string|max:25',
        'description' => 'nullable|string|max:255'
    ];

    public static array $updateRules = [
        'parent_category_id' => 'nullable|integer',
        'month_budget_id' => 'nullable|integer',
        'name' => 'required|string|max:25',
        'slug' => 'required|string|max:25',
        'color' => 'required|string|max:25',
        'icon' => 'required|string|max:25',
        'description' => 'nullable|string|max:255'
    ];

    /**---------------------
     * - Relationships:
     * ---------------------**/
    public const relations = ['user', 'monthBudget'];

    /**
     * Get the user the category belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the month budget the category belongs to.
     */
    public function monthBudget(): BelongsTo
    {
      return $this->belongsTo(MonthBudget::class, 'month_budget_id');
    }

    /**---------------------
     * - Accessors and Mutators:
     * ---------------------**/

     public function userId(): Attribute
     {
         return Attribute::get(fn($value)=> HashableService::getHash($value, 'User'));
     }

     public function parentCategoryId(): Attribute
    {
        return new Attribute(
            get: fn ($value) => HashableService::getHash($value, 'Category'),
            set: fn ($value) => HashableService::decodeHash($value, 'Category'),
        );
    }

    public function monthBudgetId(): Attribute
    {
        return new Attribute(
            get: fn ($value) => HashableService::getHash($value, 'MonthBudget'),
            set: fn ($value) => HashableService::decodeHash($value, 'MonthBudget'),
        );
    }
}
