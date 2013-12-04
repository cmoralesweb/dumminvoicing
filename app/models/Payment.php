<?php
use LaravelBook\Ardent\Ardent;
class Payment extends Ardent
{
    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'invoice_id' => 'required|numeric',  // Parent Invoice ID
        'amount' => 'required|numeric|between:0,9999999999999999999999999'
    );

    // /**
    //  * Array used by FactoryMuff to create Test objects
    //  */
    // public static $factory = array(
    //     'name' => 'string',
    //     'user_id' => 'factory|User', // Will be the id of an existent User.
    // );


    /**
     * Belongs to one Invoice
     */
    public function invoice()
    {
        return $this->belongsTo( 'Invoice');
    }

}
