<?php

namespace Modules\BackupModule\Services;

use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\File;

class BackupService
{
  public function export(?string $path = null): string
  {
    $relativePath = $path ?? 'backups/backup-' . now()->format('Ymd_His') . '.sql';
    $storagePath = storage_path('app/' . $relativePath);

    $directory = dirname($storagePath);
    if (!File::exists($directory)) {
      File::makeDirectory($directory, 0755, true);
    }
    $db = config('database.connections.' . config('database.default'));

    $mysqldumpPath = "C:\\xampp\\mysql\\bin\\mysqldump.exe";
    $mysqldump = '"' . $mysqldumpPath . '"';
    $quotedPath = '"' . $storagePath . '"';


    $cmd = "{$mysqldump} -u{$db['username']} --password={$db['password']} {$db['database']} --result-file={$quotedPath}";

    logger()->debug("Running command: $cmd");
    $process = Process::fromShellCommandline($cmd);
    $process->run();

    if (!$process->isSuccessful()) {
      throw new \Exception('Backup failed: ' . $process->getErrorOutput());
    }

    return $relativePath;
  }
}
