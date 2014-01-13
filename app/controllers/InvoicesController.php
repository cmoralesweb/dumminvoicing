<?php

class InvoicesController extends \BaseController
{

    protected $series;
    protected $currentUser;

    public function __construct(Series $series)
    {
        $this->series = $series;

        //Invoices will be automatically owned by the logged in user.
        $this->currentUser = Auth::user();

        $this->beforeFilter('auth');
    }

	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($series_id = false)
    {
        $data = array();
        //If a series_id is passed as a parameter, make sure that series exists.
        if ($series_id) {
            $this->series = $this->series->findOrFail($series_id);
            $data['series_id'] = $series_id; //Series id is passed to pre-populate that field
        }
        return View::make('invoices.create', $data);
    }

}