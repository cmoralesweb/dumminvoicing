<?php
use LaravelBook\Ardent\Ardent;
class Invoice extends Ardent
{
    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'invoice_id' => 'required|numeric',  // Parent Invoice ID
        'product_name' => 'required',
        'quantity' => 'required|numeric|between:0,9999999999999999999999999',
        'unit_price' => 'required|numeric|between:0,9999999999999999999999999',
        'tax_amount' => 'required|numeric|between:-9999999999999999999999999,9999999999999999999999999',
        'gross_total' => 'required|numeric|between:-9999999999999999999999999,9999999999999999999999999',
        'discount' => 'numeric|between:-9999999999999999999999999,9999999999999999999999999',
        'discount_type' => 'in:percent, fixed'
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

    /**
     * Can have many taxes applied
     */
    public function appliedTaxes()
    {
        return $this->hasMany( 'AppliedTax');
    }

}
