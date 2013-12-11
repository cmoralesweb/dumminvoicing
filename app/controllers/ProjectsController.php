<?php

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
        $isSaved = $this->project->save();
        if ( $isSaved ) {
            return Redirect::route('projects.index')
            ->with('message', Lang::get('projects.project_created'));
        }
        $errors = $this->project->errors()->all();
        return Redirect::route('projects.create')
        ->withInput()
        ->withErrors($errors);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$data['project'] = $this->project->find($id);

        return View::make('projects.show', $data);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $data['project'] = $this->project->find($id);
		return View::make('projects.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $project = $this->project->find($id);
        $isUpdated = $project->save();
        if ( $isUpdated ) {
            return Redirect::route('projects.show', $id)
            ->with('flash', Lang::get('projects.project_created'));
        }
        $errors = $this->project->errors()->all();
        return Redirect::route('projects.edit', $id)
        ->withInput()
        ->withErrors($errors);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$project = $this->project->find($id);
        return $project->delete();
	}

}