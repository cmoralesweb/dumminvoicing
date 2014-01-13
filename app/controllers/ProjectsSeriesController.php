<?php

class ProjectsSeriesController extends \BaseController
{

    protected $series;
    protected $currentUser;
    protected $project;

    public function __construct(Project $project, Series $series)
    {
        $this->series = $series;
        $this->project = $project;

        //Series will be automatically owned by the logged in user.
        $this->currentUser = Auth::user();

        $this->beforeFilter('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($project_id)
	{
        $this->project = $this->project->findOrFail($project_id);//Project must exist
		$data['series'] = $this->series->whereProjectId($project_id)->get();
        return View::make('series.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($project_id)
	{
        $this->project = $this->project->findOrFail($project_id); //Project must exist
        $data['project_id'] = $project_id;
		return View::make('series.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($project_id)
	{
        $this->series->user_id = $this->currentUser->id;
        $this->project = $this->project->findOrFail($project_id); //Project must exist
		$this->series->project()->associate($this->project);
        $isSaved = $this->series->save();
        if ( $isSaved ) {
            return Redirect::route('projects.series.index', $project_id)
            ->with('flash', Lang::get('series.invoice_created'));
        }
        $errors = $this->series->errors()->all();
        return Redirect::route('projects.series.create', $project_id)
        ->withInput()
        ->withErrors($errors);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($project_id, $id)
	{
		$data['series'] = $this->series->whereProjectId($project_id)->findOrFail($id);
        return View::make('series.show', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
     */

	public function edit($project_id, $id)
	{
        $data['series'] = $this->series->whereProjectId($project_id)->findOrFail($id);
        return View::make('series.edit', $data)->with('project_id', $project_id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($project_id, $id)
	{
		$this->series = $this->series->whereProjectId($project_id)->findOrFail($id);
        $isUpdated = $this->series->save();
        if ( $isUpdated ) {
            return Redirect::route('projects.series.show', array($project_id, $id))
            ->with('flash', Lang::get('projects.invoice_created'));
        }
        $errors = $this->series->errors()->all();
        return Redirect::route('projects.series.edit', array($project_id, $id))
        ->withInput()
        ->withErrors($errors);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($project_id, $id)
	{
        $this->series = $this->series->whereProjectId($project_id)->findOrFail($id);
        $this->series->delete();
        return Redirect::route('projects.series.index', 1)
            ->with('flash', Lang::get('projects.project_deleted'));return Redirect::route('projects.series.index', $project_id);
	}

}