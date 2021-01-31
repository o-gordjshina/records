<?php


namespace Gordyush\Records\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class AstCdr extends Model
{
    protected $table = 'ast_cdr';
    protected $connection = 'sod';

    public $timestamps = false;
}
