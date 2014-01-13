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
        'prefix' => 'required',
        'project_id' => 'required|numeric'
    );

    /**
     * Array used by FactoryMuff to create Test objects
     */
    public static $factory = array(
        'name' => 'string',
        'prefix' => 'string', // Will be the id of an existent User.
        'project_id' => 'factory|Project', // Will be the id of an existent Project.
    );


    /**
     * Can have many Invoices
     */
    public function invoices()
    {
        return $this->hasMany( 'Invoice');
    }


    /**
     * Belongs to one Project
     */
    public function project()
    {
        return $this->belongsTo( 'Project');
    }

}
