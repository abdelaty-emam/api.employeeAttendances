<?php

namespace App\Helpers;

class Helper
{
    /**
     * get Paginate of the rows resource from storage.
     * @param object $rows
     * @return array
     */
    public static function paginate($rows): array
    {
        $paginate = $rows->toArray();
        unset($paginate['data'], $paginate['links']);

        return $paginate;
    }
}
