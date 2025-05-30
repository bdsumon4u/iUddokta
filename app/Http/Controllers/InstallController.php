<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfInstalled;
use App\Http\Requests\InstallRequest;
use App\Install\AdminAccount;
use App\Install\App;
use App\Install\Database;
use App\Install\Requirement;
use App\Install\Store;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class InstallController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfInstalled::class);
    }

    public function preInstallation(Requirement $requirement)
    {
        return view('install.pre_installation', compact('requirement'));
    }

    public function getConfiguration(Requirement $requirement)
    {
        if (! $requirement->satisfied()) {
            return redirect('install/pre-installation');
        }

        return view('install.configuration', compact('requirement'));
    }

    public function postConfiguration(
        InstallRequest $request,
        Database $database,
        AdminAccount $admin,
        Store $store,
        App $app
    ) {
        @set_time_limit(0);

        try {
            $database->setup($request->db);
            $admin->setup($request->admin);
            $store->setup($request->store);
            $app->setup();
        } catch (Exception $e) {
            return back()->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect('install/complete');
    }

    public function complete()
    {
        if (config('app.installed')) {
            return redirect()->url('/');
        }

        $env = DotenvEditor::load();

        $env->setKey('SESSION_DRIVER', 'database');
        $env->setKey('APP_INSTALLED', 'true');
        $env->save();
        Artisan::call('optimize');

        return view('install.complete');
    }
}
