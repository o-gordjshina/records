<?php


namespace Smter\Records\Services\Records\Repositories;


use Gordyush\Records\Models\ModRecords;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EloquentModRecordsRepository
{

    public function getRecords(string $connection, array $data):?Collection
    {
        if ($connection == 'qsiq')
        {
            $link = env('LINK_RECORDS_QSIQ');
        } else {
            $link = env('LINK_RECORDS_QSIQKZ');
        }

        $records = ModRecords::on($connection)
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
