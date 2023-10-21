<?php

namespace App\Http;

use App\Models\Category;
use App\Models\MonthBudget;
use App\Services\HashableService as ServicesHashableService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class EntityExists
{
    protected string $modelName;
    protected string $modelClass;
    protected string $field;

    /**
     * Useful for confirming a fk constraint is valid.
     *
     * @param string $model
     * @param string $field
     *
     * @throws Exception
     */
    public function __construct(string $model, string $field = 'id')
    {
        $this->modelName = Str::studly($model);
        $this->modelClass = (string) Relation::getMorphedModel($this->modelName);

        if (empty($this->modelClass)) {
            throw new Exception("Model name '{$model}' is invalid");
        }
        $this->field = $field;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     * @throws Exception
     */
    public function passes($attribute, $value): bool
    {
      // return true;
      /*
      * Bail if we are testing and config setting tells us not to validate.
      */
      if (!config('app.validate_foreign_keys') && App::runningUnitTests()) {
            return true;
        }
        
        $userId = Auth::user()?->getKey();
        
        return (bool) Cache::remember(
              "user_id:{$userId}|{$this->modelName}|{$this->field}:{$value}",
              60,
              function () use ($value) {
                  // $unhashedValue = ServicesHashableService::decodeHash($value, $this->modelName);
                  /** @var Eloquent $modelClass */
                  $modelClass = $this->modelClass;
            
            // dump([$modelClass, $unhashedValue]);
            return MonthBudget::where('id', 1)->exists();
            // return MonthBudget::where('id', ServicesHashableService::getHash(1, 'MonthBudget'))->exists();
              // return $modelClass::where($this->field, $value)->exists();
          }
        );
    }

    public function message(): string
    {
        return trans('validation.entity_exists');
    }
}
