<?php

class InvoicesControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mock = $this->mock('Invoice');
        $this->mockProject = $this->mock('Project');
    }

    public function mock($class)
    {
        $mock = Mockery::mock('Eloquent', $class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    public function testRedirectWhenNotLogged()
    {
        Route::enableFilters();
        $this->call('GET', 'projects/1/invoices');
        $this->assertRedirectedToAction('UserController@getLogin');
    }

    public function testAllowedWhenLogged()
    {
        Route::enableFilters();
        //Create user and log in
        $this->mockAuth();
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('get')->once();
        $response = $this->call('GET', 'projects/1/invoices');
        $this->assertResponseOk();
    }

    public function testIndex()
    {
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('get')->once();
        $this->call('GET', 'projects/1/invoices');
        $this->assertViewHas('invoices');
    }


    public function testCreate()
    {
        $this->mockProject->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mockProject);
        $response = $this->call('GET', 'projects/1/invoices/create');
        $this->assertViewHas('project_id');
    }

    public function testStoreFails()
    {
        $user = $this->mockAuth();
        $this->mock->shouldReceive('setAttribute')
        ->once()
        ->with('user_id', $user->id);

        $this->mockProject->shouldReceive('getAttribute')->once()->with('id')->andReturn(1);
        $this->mockProject->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mockProject);

        $this->mock->shouldReceive('setAttribute')
        ->once()
        ->with('project_id', 1);

        $this->mock->shouldReceive('save')->once()->andReturn(false);

    // Mock MessageBag and all() method
        $errors = Mockery::mock('Illuminate\Support\MessageBag');
        $errors->shouldReceive('all')->once()->andReturn(array('foo' => 'bar'));

    // Mock errors() method from model and make it return the MessageBag mock
        $this->mock->shouldReceive('errors')->andReturn($errors);

    // Proceed to make the post call
        $this->call('POST', 'projects/1/invoices');
        $this->assertRedirectedToRoute('projects.invoices.create', 1);
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $user = $this->mockAuth();

        $this->mockProject->shouldReceive('getAttribute')->once()->with('id')->andReturn(1);
        $this->mockProject->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mockProject);

        $this->mock->shouldReceive('setAttribute')
        ->once()
        ->with('user_id', $user->id);

        $this->mock->shouldReceive('setAttribute')
        ->once()
        ->with('project_id', 1);

        $this->mock->shouldReceive('save')
        ->once()
        ->andReturn(true);

        $this->call('POST', 'projects/1/invoices');
        $this->assertRedirectedToRoute('projects.invoices.index', 1);
        $this->assertSessionHas('message');
    }

    public function testShow()
    {
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);

        $this->call('GET', 'projects/1/invoices/1');

        $this->assertViewHas('invoice');
    }

    public function testEdit()
    {
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $this->call('GET', 'projects/1/invoices/1/edit');
        $this->assertViewHas('invoice');
    }

    public function testUpdateFails()
    {
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('save')->once()->andReturn(false);

    // Mock MessageBag and all() method
        $errors = Mockery::mock('Illuminate\Support\MessageBag');
        $errors->shouldReceive('all')->once()->andReturn(array('foo' => 'bar'));

    // Mock errors() method from model and make it return the MessageBag mock
        $this->mock->shouldReceive('errors')->andReturn($errors);

    // Proceed to make the post call
        $this->call('PUT', 'projects/1/invoices/1');
        $this->assertRedirectedToRoute('projects.invoices.edit', array(1, 1));
        $this->assertSessionHasErrors();
    }

    public function testUpdateSuccess()
    {
       $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
       $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);
       $this->mock->shouldReceive('save')
       ->once()
       ->andReturn(true);

       $this->call('PUT', 'projects/1/invoices/1');

       $this->assertRedirectedToRoute('projects.invoices.show', array(1, 1));
       $this->assertSessionHas('flash');
   }

    public function testDelete()
    {
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('delete');
        $this->call('DELETE', 'projects/1/invoices/1');
        $this->assertRedirectedToRoute('projects.invoices.index', 1);
        $this->assertSessionHas('flash');
    }
}
