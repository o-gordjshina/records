<?php


namespace Gordyush\Records\Services\Records;

use Gordyush\Records\Services\Records\Repositories\EloquentAstCdrRepository;
use Gordyush\Records\Services\Records\Repositories\EloquentModRecordsRepository;

class Records
{
    const ASTCDR_CONNECTION
        = array(
            'sod',
            'sod3'
        );
    const MODRECORDS_CONNECTION = array(
        'qsiq' ,
        'qsiqkz'
    );

    const SIMPLE_RECORDS_FIELDS
        = array(
            'calldate' ,
            'phone',
            'billsec',
            'link',
        );


    private EloquentModRecordsRepository $eloquentModRecordsRepository;
    private EloquentAstCdrRepository $eloquentAstCdrRepository;

    public function __construct(EloquentModRecordsRepository $eloquentModRecordsRepository,
        EloquentAstCdrRepository $eloquentAstCdrRepository)
    {
        $this->eloquentModRecordsRepository = $eloquentModRecordsRepository;
        $this->eloquentAstCdrRepository = $eloquentAstCdrRepository;
    }

    public function getRecords(array $data)
    {
        if (preg_match("/^\d{2}\.\d{2}\.\d{4}$/", $data['date_period'], $matches))
        {
            $data['dates'][0]=$data['dates'][1]=$data['date_period'];
        } else {
            $data['dates'] = explode(' — ',$data['date_period']);
        }
        $records = collect();
        foreach (self::ASTCDR_CONNECTION as $connection) {
            $records = $records->merge($this->eloquentAstCdrRepository->getRecords($connection, $data));
        }
        foreach (self::MODRECORDS_CONNECTION as $connection) {
            $records =  $records->merge($this->eloquentModRecordsRepository->getRecords($connection,$data));
        }
        return $records;
    }


}
