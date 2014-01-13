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

    public function testRelationshipWithSeries()
    {
        $project = FactoryMuff::create('Project');
        $project->save();

        $series = FactoryMuff::create('Series');
        $series->project()->associate($project)->save();

        $this->assertEquals($series->id, $project->series()->first()->id);
    }

}