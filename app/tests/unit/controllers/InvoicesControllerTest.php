<?php
use Zizaco\FactoryMuff\Facade\FactoryMuff;

class InvoicesControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mock = $this->mock('Invoice');
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
        $response = $this->call('GET', 'invoices/create');
        $this->assertRedirectedToAction('UserController@getLogin');
    }

    public function testAllowedWhenLogged()
    {
        Route::enableFilters();
        //Create user and log in
        $this->mockAuth();
        $response = $this->call('GET', 'invoices/create');
        $this->assertResponseOk();
    }

    public function testCreate()
    {
        $response = $this->call('GET', 'invoices/create');
        $view = $response->original;
        $this->assertInstanceOf('Illuminate\View\View', $view);
    }

    // public function testStoreFails()
    // {
    //     $user = $this->mockAuth();
    //     $this->mock->shouldReceive('setAttribute')
    //     ->once()
    //     ->with('user_id', $user->id);

    //     $this->mock->shouldReceive('save')->once()->andReturn(false);

    // // Mock MessageBag and all() method
    //     $errors = Mockery::mock('Illuminate\Support\MessageBag');
    //     $errors->shouldReceive('all')->once()->andReturn(array('foo' => 'bar'));

    // // Mock errors() method from model and make it return the MessageBag mock
    //     $this->mock->shouldReceive('errors')->andReturn($errors);

    // // Proceed to make the post call
    //     $this->call('POST', 'projects');
    //     $this->assertRedirectedToRoute('projects.create');
    //     $this->assertSessionHasErrors();
    // }

    // public function testStoreSuccess()
    // {
    //     $user = $this->mockAuth();

    //     $this->mock->shouldReceive('setAttribute')
    //     ->once()
    //     ->with('user_id', $user->id);

    //     $this->mock->shouldReceive('save')
    //     ->once()
    //     ->andReturn(true);

    //     $this->call('POST', 'projects');
    //     $this->assertRedirectedToRoute('projects.index');
    //     $this->assertSessionHas('flash');
    // }
}
