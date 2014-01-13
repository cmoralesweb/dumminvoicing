<?php

class ProjectsSeriesInvoicesControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mock = $this->mock('Invoice');
        $this->mockSeries = $this->mock('Series');
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
        $this->call('GET', 'projects/1/series/1/invoices');
        $this->assertRedirectedToAction('UserController@getLogin');
    }

    public function testAllowedWhenLogged()
    {
        Route::enableFilters();
        //Create user and log in
        $this->mockAuth();
        $this->mockSeries->shouldReceive('findOrFail')->once()->andReturn($this->mockProject);
        $this->mock->shouldReceive('whereSeriesId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('get')->once();
        $response = $this->call('GET', 'projects/1/series/1/invoices');
        $this->assertResponseOk();
    }

    public function testIndex()
    {
        $this->mockSeries->shouldReceive('findOrFail')->once()->andReturn($this->mockProject);
        $this->mock->shouldReceive('whereSeriesId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('get')->once();
        $this->call('GET', 'projects/1/series/1/invoices');
        $this->assertViewHas('invoices');
    }


    public function testShow()
    {
        $this->mock->shouldReceive('whereSeriesId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);

        $this->call('GET', 'projects/1/series/1/invoices/1');

        $this->assertViewHas('invoice');
    }

    public function testEdit()
    {
        //Partial mock, we don't want the view messing around with this controller
        $this->mock = Mockery::mock('Eloquent', 'Invoice[findOrFail,whereSeriesId]');
        $this->app->instance('Invoice', $this->mock);

        $this->mock->shouldReceive('whereSeriesId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);

        $this->call('GET', 'projects/1/series/1/invoices/1/edit');
        $this->assertViewHas('invoice');
    }

    public function testUpdateFails()
    {
        $this->mockSeries->shouldReceive('findOrFail')->once()->andReturn($this->mockProject);
        $this->mock->shouldReceive('whereSeriesId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('save')->once()->andReturn(false);

    // Mock MessageBag and all() method
        $errors = Mockery::mock('Illuminate\Support\MessageBag');
        $errors->shouldReceive('all')->once()->andReturn(array('foo' => 'bar'));

    // Mock errors() method from model and make it return the MessageBag mock
        $this->mock->shouldReceive('errors')->andReturn($errors);

    // Proceed to make the call
        $this->call('PUT', 'projects/1/series/1/invoices/1');
        $this->assertRedirectedToRoute('projects.series.invoices.edit', array(1, 1, 1));
        $this->assertSessionHasErrors();
    }

    public function testUpdateSuccess()
    {
       $this->mockSeries->shouldReceive('findOrFail')->once()->andReturn($this->mockProject);
       $this->mock->shouldReceive('whereSeriesId')->once()->with(1)->andReturn($this->mock);
       $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);
       $this->mock->shouldReceive('save')->once()->andReturn(true);

       // Proceed to make the call
       $this->call('PUT', 'projects/1/series/1/invoices/1');
       $this->assertRedirectedToRoute('projects.series.invoices.show', array(1, 1, 1));
       $this->assertSessionHas('flash');
   }

    public function testDelete()
    {
        $this->mock->shouldReceive('whereSeriesId')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('findOrFail')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('delete');
        $this->call('DELETE', 'projects/1/series/1/invoices/1');
        $this->assertRedirectedToRoute('projects.series.invoices.index', array(1, 1));
        $this->assertSessionHas('flash');
    }
}
