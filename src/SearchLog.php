<?php

namespace Shpik\SearchLog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Class SearchLog
 * @package App\Models
 */
class SearchLog extends Model
{
    /**
     * @var string
     */
    protected $table = 'search_logs';

    /**
     * @var array
     */
    protected $fillable = [
        'query',
        'title',
        'is_active',
        'counter',
        'redirect_url',
        'created_at',
        'updated_at',
    ];

    /**
     * @param string $query
     * @return SearchLog|null
     */
    public static function processQuery(string $query)
    {
        $searchLog = self::active()->where('query', trim($query))->first();

        if (!$searchLog) {
            $searchLog =  SearchLog::create([
                'query' => trim($query),
                'counter' => 0
            ]);
        }

        $searchLog->increment('counter');

        if (!$searchLog->redirect_url) {
            return null;
        }

        return $searchLog;
    }

    /**
     * @param string $query
     * @return mixed
     */
    public static function getSearchLog(string $query)
    {
        return self::active()
            ->where('query', trim($query))
            ->whereNotNull('redirect_url')
            ->where('redirect_url', '!=', '')
            ->first();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
