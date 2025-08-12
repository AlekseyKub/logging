<?php

namespace Severnaya\Logging\Observers;

use Illuminate\Database\Eloquent\Model;
use Severnaya\Logging\Models\ModelLog;  /// Severnaya

class ModelObserver
{
    public function created(Model $model)
    {
        if (!$this->shouldLog($model)) {
            return;
        }

        ModelLog::create([
            'user_id' => auth()->id(),
            'loggable_id' => $model->getKey(),
            'loggable_type' => get_class($model),
            'action' => 'created',
            'description' => 'Запись создана',
        ]);
    }

    public function updated(Model $model)
    {
        if (!$this->shouldLog($model)) {
            return;
        }

        $fillable = $model->getFillable();
        $changes = $model->getChanges();
        $original = $model->getOriginal();

        $fields = array_intersect(array_keys($changes), $fillable);

        foreach ($fields as $field) {
            ModelLog::create([
                'user_id' => auth()->id(),
                'loggable_id' => $model->getKey(),
                'loggable_type' => get_class($model),
                'column' => $field,
                'value_old' => $original[$field] ?? null,
                'value_new' => $changes[$field] ?? null,
                'action' => 'updated',
                'description' => 'Запись обновлена',
            ]);
        }
    }

    public function deleted(Model $model)
    {
        if (!$this->shouldLog($model)) {
            return;
        }

        ModelLog::create([
            'user_id' => auth()->id(),
            'loggable_id' => $model->getKey(),
            'loggable_type' => get_class($model),
            'action' => 'deleted',
            'description' => 'Запись удалена',
        ]);
    }

    public function restored(Model $model)
    {
        if (!$this->shouldLog($model)) {
            return;
        }

        ModelLog::create([
            'user_id' => auth()->id(),
            'loggable_id' => $model->getKey(),
            'loggable_type' => get_class($model),
            'action' => 'restored',
            'description' => 'Запись восстановлена',
        ]);
    }

    protected function shouldLog(Model $model): bool
    {
        $models = config('logging.models', []);
        return in_array(get_class($model), $models, true);
    }
}

