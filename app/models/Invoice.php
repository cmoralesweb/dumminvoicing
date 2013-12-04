<?php
use LaravelBook\Ardent\Ardent;
class Invoice extends Ardent
{
    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'state' => 'in:payed, pending',
        'emitter_email' => 'email',
        'recipient_email' => 'email',
        'user_id' => 'required|numeric',  // User creator id
        'project_id' => 'required|numeric',
        'series_id' => 'required|numeric'
    );

    // /**
    //  * Array used by FactoryMuff to create Test objects
    //  */
    // public static $factory = array(
    //     'name' => 'string',
    //     'user_id' => 'factory|User', // Will be the id of an existent User.
    // );

    /**
     * Created by an User
     */
    public function creator()
    {
        return $this->belongsTo( 'User', 'user_id');
    }

    /**
     * Belongs to one Project
     */
    public function project()
    {
        return $this->belongsTo( 'Project');
    }


    /**
     * Belongs to one series (group of Invoices)
     */
    public function series()
    {
        return $this->belongsTo( 'Series', 'series_id');
    }

    /**
     * Can have many Payments
     */
    public function payments()
    {
        return $this->hasMany( 'Payment');
    }

}
