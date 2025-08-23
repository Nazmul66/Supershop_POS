<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DBbackupController extends Controller
{
    public function pull_backup()
    {
        Artisan::call('app:dbbackup');

        Toastr::success('Database Backup successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }

    public function list_backup()
    {
        $backups = collect(Storage::files('backup'))
            ->sortByDesc(fn($file) => Storage::lastModified($file)) // sort by timestamp
            ->values(); // reset array keys
        return view('admin.pages.settings.backup.index', compact('backups'));
    }

    public function backup_download($file)
    {
        $filePath = "backup/{$file}";

        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }

        return redirect()->back()->with('error', 'File not found!');

    }

    public function backup_delete($file)
    {
        $filePath = "backup/{$file}";

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);

             Toastr::success('✅ Backup deleted successfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    
        Toastr::error('❌ Backup file not found!', 'Error', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }
}
