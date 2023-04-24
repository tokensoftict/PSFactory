<?php

namespace App\Repositories;

class UnitConverterRepository
{
    public function __construct()
    {
        //
    }

    /**
     * @param string $from
     * @param string $to
     * @param float|int $value
     * @return int|float
     */
    public static function convert(string $from,  string $to, float|int $value) : int|float{

        $unitFrom  = self::getUnit($from);
        $unitTo = self::getUnitTo($unitFrom, $to);

        return match ($unitTo['operation']) {
            "/" => ($value / $unitTo['unit']),
            "*" => ($value * $unitTo['unit']),
            default => 0,
        };

    }


    public static function getUnitTo($unit, $id) : array{
        $selected = [];
        foreach($unit['to'] as $unit){
            if($unit['id'] === $id){
                $selected = $unit;
                break;
            }
        }
        return $selected;
    }

    public static function getUnit($id) : array {
        $selected = [];
        foreach(self::getUnits() as $unit)
        {
            if($unit['id'] === $id){
                $selected = $unit;
                break;
            }
        }
        return $selected;
    }

    public static function getUnits() : array{
        return  config('convert');
    }
}
