<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class BaseBuilder
{
    protected $_model;
    protected $_offset;
    protected $_pageCount;
    protected $selectors;
    protected $selector;

    abstract public function __construct();

    public function with($with = [])
    {
        $this->_model->with($with);

        return $this;
    }

    public function withAvg($relation, $col)
    {
        if(!empty($relation) && !empty($col))
            $this->_model->withAvg($relation, $col);

        return $this;
    }

    private function selectWithSelector($select)
    {
        $selector = $this->selector;
        $selector = new $selector($this->_model);
        $selector->select($select);
    }

    private function selectWithSelectorsArray($select)
    {
        $i = 0;
        foreach ($select as $item) {
            if (is_string($item) && isset($this->selectors[$item])) {
                $select[$i] = DB::raw($this->selectors[$item]);
            }
            $i++;
        }

        $this->_model->select($select);
    }

    public function select($select = ['*'])
    {
        if (!is_null($select)) {
            if (!is_null($this->selector))
                $this->selectWithSelector($select);
            else
                $this->selectWithSelectorsArray($select);
        }
        return $this;
    }

    public function search($text, $columns = [])
    {
        if (empty($text)) {
            return $this;
        }

        $this->_model->where(function ($query) use ($text, $columns) {
            foreach ($columns as $column) {
                $query->orwhere($column, 'LIKE', "%{$text}%");
            }
        });
        return $this;
    }


    /**
     * @return Collection
     */
    public function get()
    {
        $model = clone $this->_model;
        $model
            ->skip($this->_offset * 25)
            ->take((int)25);

        return $model->get();
    }

    /**
     * @return Collection
     */

    public function getWithPageCount()
    {
        $pageCount = $this->_pageCount ?? 25;
        $model = clone $this->_model;
        $model
            ->skip($this->_offset * $pageCount)
            ->take($pageCount);

        return $model->get();
    }



    /**
     * @return Collection
     */
    public function getAll()
    {
        return $this->_model->get();
    }

    public function count()
    {
        return $this->_model->count();
    }

    public function first()
    {
        return $this->_model->first();
    }

    public function firstOrFail()
    {
        return $this->_model->firstOrFail();
    }

    public function offset($offset = 0)
    {
        $this->_offset = $offset;

        return $this;
    }

    public function pageCount($pageCount = 25)
    {
        $this->_pageCount = $pageCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSelectors()
    {
        return $this->selectors;
    }

    public function order($orderBy, $orderType)
    {
        $this->_model->orderBy($orderBy ?? 'id', $orderType ?? 'desc');

        return $this;
    }

    public function limit($limit)
    {
        if (!is_null($limit)) {
            $this->_model->limit($limit);
        }
        return $this;
    }


    public function countOfGroups()
    {
        $query = $this->_model->toSql();
        $query = "SELECT COUNT(*) as c FROM
                    (
                        $query
                    )
                    as rows_count";

        $resp = DB::select($query, $this->_model->getBindings());

        return $resp[0]->c;
    }


    public function union($query)
    {
        $this->_model->union($query);
        return $this;
    }

    /**
     * @return Builder
     */
    public function getModel()
    {
        return $this->_model;
    }

    public function setModel($model)
    {
        $this->_model = $model;

        return $this;
    }

    public function customSort($phrase)
    {
        $decoder = (new CustomSortDecoder())->decode($phrase);
        return $this->order($decoder->orderBy, $decoder->orderType);
    }
}
