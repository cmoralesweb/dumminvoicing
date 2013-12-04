<?php
namespace Dumminvoicing\Storage;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider {

  public function register()
  {
    $this->app->bind(
      'Dumminvoicing\Storage\Project\ProjectRepository',
      'Dumminvoicing\Storage\Project\EloquentProjectRepository'
    );
  }

}