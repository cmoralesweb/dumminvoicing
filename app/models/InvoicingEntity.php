<?php
use LaravelBook\Ardent\Ardent;
class InvoicingEntity extends Ardent
{
    protected $table = 'invoicing_entities';
    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'email' => 'email'
    );

    // /**
    //  * Array used by FactoryMuff to create Test objects
    //  */
    // public static $factory = array(
    //     'name' => 'string',
    //     'user_id' => 'factory|User', // Will be the id of an existent User.
    // );
}
