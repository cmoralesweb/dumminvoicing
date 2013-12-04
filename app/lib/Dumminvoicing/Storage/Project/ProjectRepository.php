<?php
namespace Dumminvoicing\Storage\Project;

interface ProjectRepository
{
    public function all();
    public function find($id);
    public function create($input);
}