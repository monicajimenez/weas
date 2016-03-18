<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    protected $primaryKey = 'unit_code';
    public $timestamps = false;

    /**
     * Retrieves a list of units
     *
     * @return Response
     */
    public function getUnit()
    {
    	return $this->get(['unit_code','unit_symbol']);
    }
}
