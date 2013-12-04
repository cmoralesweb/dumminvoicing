<?php
use LaravelBook\Ardent\Ardent;
class AppliedTax extends Ardent
{
    protected $table = 'applied_taxes';

    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'item_id' => 'required|numeric',  // Parent Invoice Item ID
        'name' => 'required',
        'percentage' => 'required|numeric|between:-99.99999999,99.99999999',
        'priority' => 'required|numeric|between:-128,127'
    );

    // /**
    //  * Array used by FactoryMuff to create Test objects
    //  */
    // public static $factory = array(
    //     'name' => 'string',
    //     'user_id' => 'factory|User', // Will be the id of an existent User.
    // );


    /**
     * Belongs to one InvoiceItem
     */
    public function item()
    {
        return $this->belongsTo( 'Item');
    }

}
