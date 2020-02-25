<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use RonasIT\Support\Traits\ModelTrait as BaseTrait;

trait ModelTrait
{
    use BaseTrait;

    public static $staticAppends = [];

    public static function setStaticAppends(array $fields = [])
    {
        self::$staticAppends = $fields;
    }

    protected function getArrayableAppends(){
        $this->append(self::$staticAppends);
        return parent::getArrayableAppends();
    }

    public function scopeAddFilterByQuery($query, $fields, $queryString)
    {
        if (!empty($queryString)) {
            $query->where(function ($query) use ($fields, $queryString) {
                foreach ($fields as $field) {
                    if (Str::contains($field, '.')) {
                        $entities = explode('.', $field);
                        $fieldName = array_pop($entities);

                        $query->orWhereHas(implode('.', $entities), function ($query) use ($fieldName, $queryString) {
                            $query->where(
                                $this->getQuerySearchCallback($fieldName, $queryString)
                            );
                        });
                    } else {
                        $query->orWhere(
                            $this->getQuerySearchCallback($field, $queryString)
                        );
                    }
                }
            });
        }

        return $this;
    }

    protected function getQuerySearchCallback($field, $queryString)
    {
        return function ($query) use ($field, $queryString) {
            $loweredQuery = mb_strtolower($queryString);
            $field = DB::raw("lower({$field})");

            $query->orWhere($field, 'like', "%{$loweredQuery}%");
        };
    }
}
