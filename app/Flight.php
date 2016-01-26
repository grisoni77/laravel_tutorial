<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * The connection name for the model.
     * Di default utilizza la connessione predefinita nel config
     */
    //protected $connection = 'connection-name';

    /**
     * The table associated with the model.
     * Di default utilizza il plurale del nome del Model
     * Per sovrascrivere il comportamento modificare e decommentare la riga sotto
     */
    //protected $table = 'my_flights';

    /**
     * The primary key associated with the model.
     * Di default utilizza 'id'
     * Per sovrascrivere il comportamento modificare e decommentare la riga sotto
     */
    //protected $primaryKey = 'flight_id';

    /**
     * Indicates if the model should be timestamped.
     * Ovvero se utilizza i campi created_at e updated_at
     * Di default è true
     */
    //public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     *
     */
    //protected $dateFormat = 'U';
}
