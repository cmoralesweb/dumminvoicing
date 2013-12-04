<?php
use Zizaco\FactoryMuff\Facade\FactoryMuff;

class ProjectControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mock = $this->mock('Dumminvoicing\Storage\Project\ProjectRepositoryInterface');
    }

    public function mock($class)
    {
        $mock = Mockery::mock($class);

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
        $user = FactoryMuff::create('User');
        $this->be($user);
        $response = $this->call('GET', 'projects');
        $this->assertResponseOk();
    }

    public function testIndex()
    {
        $this->mock->shouldReceive('all')->once();
        $this->call('GET', 'projects');
        $this->assertViewHas('projects');
    }

    // public function testCreate()
    // {
    //     $response = $this->call('GET', 'projects/create');
    //     $view = $response->original;
    //     $this->assertInstanceOf('Illuminate\View\View', $view);
    // }

    // public function testStoreFails()
    // {
    //     $this->mock->shouldReceive('create')
    //         ->once()
    //         ->andReturn(Mockery::mock(array(
    //                 false,
    //                 'errors' => array()
    //                 )));
    //     $this->call('POST', 'projects');
    //     $this->assertRedirectedToRoute('projects.create');
    //     $this->assertSessionHasErrors();
    // }

}