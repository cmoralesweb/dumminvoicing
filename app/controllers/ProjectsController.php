<?php

use Dumminvoicing\Storage\Project\ProjectRepository as Project;

class ProjectsController extends \BaseController
{
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;

        $this->beforeFilter('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $data['projects'] = $this->project->all();
		return View::make('projects.index', $data) ;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('projects.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// $project = $this->project->create(Input::all());
  //       if ( $project ) {
  //           return Redirect::route('projects.index')
  //           ->with('flash', Lang::get('projects.project created'));
  //       }
  //       return Redirect::route('projects.create')
  //       ->withInput()
  //       ->withErrors($projects->errors());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}