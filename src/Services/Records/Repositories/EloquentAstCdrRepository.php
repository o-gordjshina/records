<?php

namespace Gordyush\Records\Services\Records\Repositories;

use Gordyush\Records\Models\AstCdr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EloquentAstCdrRepository
{
    public function getRecords(string $connection, array $data):Collection
    {
        if ($connection == 'sod')
        {
            $link = env('LINK_RECORDS_SOD');
        } else {
            $link = env('LINK_RECORDS_SOD3');
        }

        $records = AstCdr::on($connection)
            ->select('calldate','src','billsec',
                DB::raw('CONCAT("'.$link.'",uniqueid,"?date=",DATE_FORMAT(calldate,"%Y-%m-%d"),"&ext=.WAV") as link'))
            ->where('calldate','>=',date('Y-m-d 00:00:00', strtotime($data['dates'][0])))
            ->where('calldate','<=',date('Y-m-d 23:59:59', strtotime($data['dates'][1])))
            ->whereQueue($data['project']);
        if (!empty($data['phone']))
        {
            $records->whereSrc($data['phone']);
        }
        return $records->get();

    }
}
