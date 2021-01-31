<?php


namespace Gordyush\Records\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModRecords extends Model
{
    protected $table = 'mod_records';
    protected $connection = 'qsiq';

    public $timestamps = false;
}
