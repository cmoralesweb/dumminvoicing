<?php
use LaravelBook\Ardent\Ardent;
class Product extends Ardent
{
    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'name' => 'required',
        'unit_price' => 'required|numeric|between:0,9999999999999999999999999'
    );

    // /**
    //  * Array used by FactoryMuff to create Test objects
    //  */
    // public static $factory = array(
    //     'name' => 'string',
    //     'user_id' => 'factory|User', // Will be the id of an existent User.
    // );

}
