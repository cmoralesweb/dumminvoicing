<?php
use Zizaco\FactoryMuff\Facade\FactoryMuff;
class SeriesModelTest extends TestCase
{
    public function testRelationshipWithInvoices()
    {
        $series = FactoryMuff::create('Series');
        $series->save();

        $invoice = FactoryMuff::create('Invoice');
        $invoice->series()->associate($series)->save();

        $this->assertEquals($invoice->id, $series->invoices()->first()->id);
    }

    public function testRelationshipWithProjects()
    {
        $series = FactoryMuff::create('Series');
        $series->save();

        $this->assertEquals($series->project_id, $series->project->id);
    }
}