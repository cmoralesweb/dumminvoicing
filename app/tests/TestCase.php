<?php
use Zizaco\FactoryMuff\Facade\FactoryMuff;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

    protected function mockAuth()
    {
        $user = FactoryMuff::create('User');
        $this->be($user);

        return Auth::user();
    }

    /**
     * Default preparation for each test
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->prepareForTests();
    }

	/**
	 * Creates the application.
	 *
	 * @return Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}
    /**
     * Migrates the database and set the mailer to 'pretend'.
     * This will cause the tests to run quickly.
     *
     */
    private function prepareForTests()
    {
        Artisan::call('migrate');
        Mail::pretend(true);
    }

}
