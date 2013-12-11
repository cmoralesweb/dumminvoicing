<?php
use Zizaco\FactoryMuff\Facade\FactoryMuff;

class ProjectControllerTest extends TestCase
{
    protected function mockAuth()
    {
        $user = FactoryMuff::create('User');
        $this->be($user);

        return Auth::user();
    }

    public function setUp()
    {
        parent::setUp();

        $this->mock = $this->mock('Project');
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
        $response = $this->call('GET', 'projects');
        $this->assertRedirectedToAction('UserController@getLogin');
    }

    public function testAllowedWhenLogged()
    {
        Route::enableFilters();
        //Create user and log in
        $this->mockAuth();
        $this->mock->shouldReceive('all')->once();
        $response = $this->call('GET', 'projects');
        $this->assertResponseOk();
    }

    public function testIndex()
    {
        $this->mock->shouldReceive('all')->once();
        $this->call('GET', 'projects');
        $this->assertViewHas('projects');
    }

    public function testCreate()
    {
        $response = $this->call('GET', 'projects/create');
        $view = $response->original;
        $this->assertInstanceOf('Illuminate\View\View', $view);
    }

    public function testStoreFails()
    {
        $user = $this->mockAuth();
        $this->mock->shouldReceive('setAttribute')
        ->once()
        ->with('user_id', $user->id);

        $this->mock->shouldReceive('save')->once()->andReturn(false);

    // Mock MessageBag and all() method
        $errors = Mockery::mock('Illuminate\Support\MessageBag');
        $errors->shouldReceive('all')->once()->andReturn(array('foo' => 'bar'));

    // Mock errors() method from model and make it return the MessageBag mock
        $this->mock->shouldReceive('errors')->andReturn($errors);

    // Proceed to make the post call
        $this->call('POST', 'projects');
        $this->assertRedirectedToRoute('projects.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $user = $this->mockAuth();

        $this->mock->shouldReceive('setAttribute')
        ->once()
        ->with('user_id', $user->id);

        $this->mock->shouldReceive('save')
        ->once()
        ->andReturn(true);

        $this->call('POST', 'projects');
        $this->assertRedirectedToRoute('projects.index');
        $this->assertSessionHas('message');
    }

    public function testShow()
    {
        $this->mock->shouldReceive('find')
        ->once()
        ->with(1);

        $this->call('GET', 'projects/1');

        $this->assertViewHas('project');
    }

    public function testEdit()
    {
        $this->mock->shouldReceive('find')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('getAttribute')->once()->with('name');
        $this->call('GET', 'projects/1/edit');
        $this->assertViewHas('project');
    }

    public function testUpdateFails()
    {
         $this->mock->shouldReceive('find')->once()->with(1)->andReturn($this->mock);
         $this->mock->shouldReceive('save')->once()->andReturn(false);

    // Mock MessageBag and all() method
        $errors = Mockery::mock('Illuminate\Support\MessageBag');
        $errors->shouldReceive('all')->once()->andReturn(array('foo' => 'bar'));

    // Mock errors() method from model and make it return the MessageBag mock
        $this->mock->shouldReceive('errors')->andReturn($errors);

    // Proceed to make the post call
        $this->call('PUT', 'projects/1');
        $this->assertRedirectedToRoute('projects.edit', 1);
        $this->assertSessionHasErrors();
    }

    public function testUpdateSuccess()
    {
        $this->mock->shouldReceive('find')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('save')
        ->once()
        ->andReturn(true);

        $this->call('PUT', 'projects/1');

        $this->assertRedirectedToRoute('projects.show', 1);
        $this->assertSessionHas('flash');
    }

    public function testDelete()
    {
        $this->mock->shouldReceive('find')->once()->with(1)->andReturn($this->mock);
        $this->mock->shouldReceive('delete');
        $this->call('DELETE', 'projects/1');
    }
}
