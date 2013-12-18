<?php
use Zizaco\FactoryMuff\Facade\FactoryMuff;
class InvoiceModelTest extends TestCase
{
    public function testRelationshipWithProjects()
    {
        $invoice = FactoryMuff::create('Invoice');
        $invoice->save();

        $this->assertEquals($invoice->project_id, $invoice->project->id);
    }

    public function testRelationshipWithUsers()
    {
        $invoice = FactoryMuff::create('Invoice');
        $invoice->save();

        $this->assertEquals($invoice->user_id, $invoice->creator->id);
    }

    public function testRelationshipWithSeries()
    {
        $invoice = FactoryMuff::create('Invoice');
        $invoice->save();

        $this->assertEquals($invoice->series_id, $invoice->series->id);
    }

}