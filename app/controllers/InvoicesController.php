<?php

class InvoicesController extends \BaseController {

    protected $invoice;
    protected $currentUser;
    protected $project;

    public function __construct(Invoice $invoice, Project $project)
    {
        $this->invoice = $invoice;
        $this->project = $project;

        //Invoices will be automatically owned by the logged in user.
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
		$data['invoices'] = $this->invoice->whereProjectId($project_id)->get();
        return View::make('invoices.index', $data);
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
		return View::make('invoices.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($project_id)
	{
        $this->invoice->user_id = $this->currentUser->id;
        $this->project = $this->project->findOrFail($project_id); //Project must exist
		$this->invoice->project_id = $this->project->id;
        $isSaved = $this->invoice->save();
        if ( $isSaved ) {
            return Redirect::route('projects.invoices.index', $project_id)
            ->with('message', Lang::get('invoices.invoice_created'));
        }
        $errors = $this->invoice->errors()->all();
        return Redirect::route('projects.invoices.create', $project_id)
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
		$data['invoice'] = $this->invoice->whereProjectId($project_id)->findOrFail($id);
        return View::make('invoices.show', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($project_id, $id)
	{
        $data['invoice'] = $this->invoice->whereProjectId($project_id)->findOrFail($id);
        return View::make('invoices.edit', $data)->with('project_id', $project_id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($project_id, $id)
	{
		$this->invoice = $this->invoice->whereProjectId($project_id)->findOrFail($id);
        $isUpdated = $this->invoice->save();
        if ( $isUpdated ) {
            return Redirect::route('projects.invoices.show', array($project_id, $id))
            ->with('flash', Lang::get('projects.invoice_created'));
        }
        $errors = $this->invoice->errors()->all();
        return Redirect::route('projects.invoices.edit', array($project_id, $id))
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
        $this->invoice = $this->invoice->whereProjectId($project_id)->findOrFail($id);
        $this->invoice->delete();
        return Redirect::route('projects.invoices.index', 1)
            ->with('flash', Lang::get('projects.project_deleted'));return Redirect::route('projects.invoices.index', $project_id);
	}

}