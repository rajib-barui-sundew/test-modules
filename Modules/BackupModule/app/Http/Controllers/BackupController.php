<?php

namespace Modules\BackupModule\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\BackupModule\Services\BackupService;

class BackupController extends Controller
{
  public function index(BackupService $service)
  {
    return response()->download(storage_path('app/' . $service->export()));
  }
}
