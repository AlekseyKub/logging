<?php

namespace Severnaya\Logging\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelLog extends Model
{
    use SoftDeletes;

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