<?php

namespace Severnaya\Logging\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLog extends Model
{
    protected $table = 'models_logs';

    protected $fillable = [
        'user_id',
        'loggable_id',
        'loggable_type',
        'column',
        'value_old',
        'value_new',
        'action',
        'description',
    ];

    public function loggable()
    {
        return $this->morphTo();
    }
}