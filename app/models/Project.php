<?php
use LaravelBook\Ardent\Ardent;
class Project extends Ardent
{
    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'name' => 'required',              // Project Title
        'user_id' => 'required|numeric',  // User owner id
    );

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    /**
     * Array used by FactoryMuff to create Test objects
     */
    public static $factory = array(
        'name' => 'string',
        'user_id' => 'factory|User', // Will be the id of an existent User.
    );

    /*
    Properties that can be mass assigned
     */
    protected $fillable = array('name');

    /**
     * Belongs to user
     */
    public function owner()
    {
        return $this->belongsTo( 'User', 'user_id');
    }

    /**
     * Many Users can be authorized
     */
    public function authorized()
    {
        return $this->belongsToMany( 'User', 'project_user', 'project_id', 'user_id')->withTimestamps();
    }

    /**
     * Can have many Series
     */
    public function series()
    {
        return $this->hasMany( 'Series', 'project_id');
    }


}
