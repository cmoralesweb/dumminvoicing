<?php
use LaravelBook\Ardent\Ardent;
class Invoice extends Ardent
{
    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'state' => 'in:payed,pending|required',
        'emitter_email' => 'email',
        'recipient_email' => 'email',
        'sent' => 'in:0,1|required',
        'user_id' => 'required|numeric',  // User creator id
        'series_id' => 'required|numeric',
    );

    /**
     * Array used by FactoryMuff to create Test objects
     * We don't need to fill all fields
     */
    public static $factory = array(
        'state' => 'pending',
        'emitter_name' => 'string',
        'emitter_surname' => 'string',
        'emitter_commercial_name' => 'string',
        'emitter_email' => 'email',
        'recipient_name' => 'string',
        'recipient_surname' => 'string',
        'recipient_email' => 'email',
        'sent' => '0',
        'user_id' => 'factory|User', // Will be the id of an existent User.
        'series_id' => 'factory|Series', // Will be the id of an existent Series.
    );

    //Attributes that can't be mass-assigned
    protected $guarded = array('id', 'user_id', 'project_id', 'series_id');

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    /**
     * Created by an User
     */
    public function creator()
    {
        return $this->belongsTo( 'User', 'user_id');
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
