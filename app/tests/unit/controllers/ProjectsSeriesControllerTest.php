<?php

class ProjectsSeriesControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mock = $this->mock('Series');
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
        $this->call('GET', 'projects/1/series');
        $this->assertRedirectedToAction('UserController@getLogin');
    }

    public function testAllowedWhenLogged()
    {
        Route::enableFilters();
        //Create user and log in
        $this->mockAuth();
        $this->mockProject->shouldReceive('findOrFail')->once()->andReturn($this->mockProject);
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('get')->once();
        $response = $this->call('GET', 'projects/1/series');
        $this->assertResponseOk();
    }

    public function testIndex()
    {
        $this->mockProject->shouldReceive('findOrFail')->once()->andReturn($this->mockProject);
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('get')->once();
        $this->call('GET', 'projects/1/series');
        $this->assertViewHas('series');
    }


    public function testCreate()
    {
        $this->mockProject->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mockProject);
        $response = $this->call('GET', 'projects/1/series/create');
        $this->assertViewHas('project_id');
    }

    public function testStoreFails()
    {
        $user = $this->mockAuth();
        $this->mock->shouldReceive('setAttribute')
        ->once()
        ->with('user_id', $user->id);

        $this->mockProject->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mockProject);

        $this->mock->shouldReceive('project')->once()->andReturn($this->mock);
        $this->mock->shouldReceive('associate')->once()->with($this->mockProject)->andReturn($this->mock);

        $this->mock->shouldReceive('save')->once()->andReturn(false);

    // Mock MessageBag and all() method
        $errors = Mockery::mock('Illuminate\Support\MessageBag');
        $errors->shouldReceive('all')->once()->andReturn(array('foo' => 'bar'));

    // Mock errors() method from model and make it return the MessageBag mock
        $this->mock->shouldReceive('errors')->andReturn($errors);

    // Proceed to make the post call
        $this->call('POST', 'projects/1/series');
        $this->assertRedirectedToRoute('projects.series.create', 1);
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $user = $this->mockAuth();
        $this->mock->shouldReceive('setAttribute')
        ->once()
        ->with('user_id', $user->id);

        $this->mockProject->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mockProject);

        $this->mock->shouldReceive('project')->once()->andReturn($this->mock);
        $this->mock->shouldReceive('associate')->once()->with($this->mockProject)->andReturn($this->mock);

        $this->mock->shouldReceive('save')
        ->once()
        ->andReturn(true);

        $this->call('POST', 'projects/1/series');
        $this->assertRedirectedToRoute('projects.series.index', 1);
        $this->assertSessionHas('flash');
    }

    public function testShow()
    {
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);

        $this->call('GET', 'projects/1/series/1');

        $this->assertViewHas('series');
    }

    public function testEdit()
    {
        //Partial mock, we don't want the view messing around with this controller
        $this->mock = Mockery::mock('Eloquent', 'Series[findOrFail,whereProjectId]');
        $this->app->instance('Series', $this->mock);

        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);

        $this->call('GET', 'projects/1/series/1/edit');
        $this->assertViewHas('series');
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
        $this->call('PUT', 'projects/1/series/1');
        $this->assertRedirectedToRoute('projects.series.edit', array(1, 1));
        $this->assertSessionHasErrors();
    }

    public function testUpdateSuccess()
    {
       $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
       $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);
       $this->mock->shouldReceive('save')
       ->once()
       ->andReturn(true);

       $this->call('PUT', 'projects/1/series/1');

       $this->assertRedirectedToRoute('projects.series.show', array(1, 1));
       $this->assertSessionHas('flash');
   }

    public function testDelete()
    {
        $this->mock->shouldReceive('whereProjectId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('delete');
        $this->call('DELETE', 'projects/1/series/1');
        $this->assertRedirectedToRoute('projects.series.index', 1);
        $this->assertSessionHas('flash');
    }
}
