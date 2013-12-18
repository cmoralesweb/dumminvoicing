<?php
use Zizaco\FactoryMuff\Facade\FactoryMuff;
class ProjectModelTest extends TestCase
{
    /**
     * Test relationship with User
     */
    public function testRelationshipWithUser()
    {
        // Instantiate new Project
        $project = FactoryMuff::create('Project');

        $this->assertEquals($project->user_id, $project->owner->id);
    }

    /**
     * Test relationship with Authorized Users
     * */
    public function testRelationshipWithAuthorizedUsers()
    {
        // Instantiate new Project
        $project = FactoryMuff::create('Project');
        $project->save();
        $project->authorized()->attach($project->user_id);

        $this->assertEquals($project->user_id, $project->authorized->first()->id);
    }

    public function testRelationshipWithInvoices()
    {
        $project = FactoryMuff::create('Project');
        $project->save();

        $invoice = FactoryMuff::create('Invoice');
        $invoice->project()->associate($project)->save();

        $this->assertEquals($invoice->id, $project->invoices()->first()->id);
    }

}