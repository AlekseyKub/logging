<?php
namespace Severnaya\Logging\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Severnaya\Logging\Models\ModelLog;

trait HasLogs
{
    /**
     *  Get logs model
     *
     * @return MorphMany
     */
    public function logs(): MorphMany
    {
        return $this->morphMany(ModelLog::class, 'loggable');
    }

}