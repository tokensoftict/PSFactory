<?php
namespace App\Traits;

trait ModelFilterTraits
{

    public function scopefilterdata($query, array $filter)
    {
        foreach ($filter as $key => $value) {
            if(str_contains($key ,'between'))
            {
                $key = str_replace('between.','', $key);

                $query->whereBetween($this->getQueryTable($key, true).$key,$value );
            }
            else {
                $query->where($this->getQueryTable($key).$key, $value);
            }
        }

        return $query;
    }


    protected function getQueryTable($criterial, $between = false) : string
    {
        if(str_contains($criterial, "."))  return $between === false ? $criterial : "";

        return $this->table.".";
    }

}
