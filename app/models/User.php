<?php

use Zizaco\Entrust\HasRole;
use Zizaco\Confide\ConfideUser;

class User extends ConfideUser {

    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'username' => 'required|min:4|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|between:4,16|confirmed'
    );

    /**
     * Array used by FactoryMuff to create Test objects
     */
    public static $factory = array(
        'username' => 'string',
        'email' => 'email',
        'password' => '12345',
        'password_confirmation' => '12345',
    );


    use HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    /*
    Properties that can be mass assigned
     */
    protected $fillable = array('username', 'email', 'password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

    /**
     * Many Users can be authorized on many Projects
     */
    public function authorizedProjects()
    {
        return $this->belongsToMany( 'Project', 'project_user', 'user_id', 'project_id')->withTimestamps();
    }

    /**
     * Users can have many Projects
     */
    public function projects()
    {
        return $this->hasMany( 'Project');
    }

}