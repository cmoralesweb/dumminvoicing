<?php

class ProjectsSeriesInvoicesController extends \BaseController
{

    protected $invoice;
    protected $currentUser;
    protected $project;
    protected $series;

    public function __construct(Project $project, Series $series, Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->project = $project;
        $this->series = $series;

        $this->beforeFilter('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($project_id, $series_id)
	{
        $this->series = $this->series->findOrFail($series_id); //Series must exist
		$data['invoices'] = $this->invoice->whereSeriesId($series_id)->get();
        return View::make('invoices.index', $data);
	}

	// /**
	//  * Show the form for creating a new resource.
	//  *
	//  * @return Response
	//  */
	// public function create($project_id, $series_id)
	// {
 //        $this->project = $this->project->findOrFail($project_id); //Project must exist
 //        $data['project_id'] = $project_id;
	// 	return View::make('invoices.create', $data);
	// }

	// /**
	//  * Store a newly created resource in storage.
	//  *
	//  * @return Response
	//  */
	// public function store($project_id)
	// {
 //        $this->invoice->user_id = $this->currentUser->id;
 //        $this->project = $this->project->findOrFail($project_id); //Project must exist
	// 	$this->invoice->project_id = $this->project->id;
 //        $isSaved = $this->invoice->save();
 //        if ( $isSaved ) {
 //            return Redirect::route('projects.invoices.index', $project_id)
 //            ->with('flash', Lang::get('invoices.invoice_created'));
 //        }
 //        $errors = $this->invoice->errors()->all();
 //        return Redirect::route('projects.invoices.create', $project_id)
 //        ->withInput()
 //        ->withErrors($errors);
	// }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($project_id, $series_id, $id)
	{
		$data['invoice'] = $this->invoice->whereSeriesId($series_id)->findOrFail($id);
        return View::make('invoices.show', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($project_id, $series_id, $id)
	{
        $data['invoice'] = $this->invoice->whereSeriesId($series_id)->findOrFail($id);
        return View::make('invoices.edit', $data)->with(array('project_id' => $project_id, 'series_id' => $series_id)) ;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($project_id, $series_id,  $id)
	{
        $this->series = $this->series->findOrFail($series_id); //Series must exist
		$this->invoice = $this->invoice->whereSeriesId($series_id)->findOrFail($id);
        $isUpdated = $this->invoice->save();
        if ( $isUpdated ) {
            return Redirect::route('projects.series.invoices.show', array($project_id, $series_id, $id))
            ->with('flash', Lang::get('invoices.invoice_edited'));
        }
        $errors = $this->invoice->errors()->all();
        return Redirect::route('projects.series.invoices.edit', array($project_id, $series_id, $id))
        ->withInput()
        ->withErrors($errors);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($project_id, $series_id, $id)
	{
        $this->invoice = $this->invoice->whereSeriesId($series_id)->findOrFail($id);
        $this->invoice->delete();
        return Redirect::route('projects.series.invoices.index', array(1,1))
            ->with('flash', Lang::get('invoices.invoice_deleted'));
	}

}