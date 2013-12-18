<?php
use LaravelBook\Ardent\Ardent;
class Series extends Ardent
{
    protected $table = "series";
    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'name' => 'required',  // Parent Invoice ID
        'prefix' => 'required'
    );

    /**
     * Array used by FactoryMuff to create Test objects
     */
    public static $factory = array(
        'name' => 'string',
        'prefix' => 'string', // Will be the id of an existent User.
    );


    /**
     * Can have many Invoices
     */
    public function invoices()
    {
        return $this->hasMany( 'Invoice');
    }

}
