<?php

namespace App\Http\Filters\V1;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilter
{
    protected $builder;
    protected $request;
    protected $sortable = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function filter($arr)
    {
        foreach ($arr as  $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    protected function sort($value)
    {
        $sortAttributes = explode(',', $value);
        foreach ($sortAttributes as $sortAttribute) {
            $direction = 'asc';
            if (strpos($sortAttribute, '-') === 0) {
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }

            // Check if the sort attribute exists in the sortable array
            if (!in_array($sortAttribute, $this->sortable) && !array_key_exists($sortAttribute, $this->sortable)) {
                continue;
            }

            // Determine the column name, fallback to the attribute itself if not mapped
            $columnName = $this->sortable[$sortAttribute] ?? $sortAttribute;

            // Apply the sort order
            $this->builder->orderBy($columnName, $direction);
        }
    }


    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->request->all() as  $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $builder;
    }
}
