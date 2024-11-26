<?php

namespace App\Http\Controllers;

use App\Helpers\Traits\ImageHelper;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Setting;
use App\Repository\SettingsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use ImageHelper;

    protected $rules = [
        'company' => 'sometimes|array',
        'social' => 'sometimes|array',
        'contact' => 'sometimes|array',
        'header_menu' => 'sometimes|array',
        'footer_menu' => 'sometimes|array',
        'courier' => 'sometimes|array',
        'form_title' => 'sometimes|array',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(SettingsRepository $settingsRepo)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        $compact = [
            'all_menus' => Menu::all(),
            'all_pages' => Page::all(),
        ];
        collect(array_keys($this->rules))
            ->map(function ($item) use (&$compact, $settingsRepo) {
                $compact[$item] = $settingsRepo->first($item)->value ?? new Setting;
            });

        return view('admin.settings.edit', $compact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingsRepository $settingsRepo)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        if ($request->password && $request->old_password && $request->password_confirmation) {
            return (new PasswordController)(...func_get_args());
        }
        $data = $request->validate($this->rules);

        tap($settingsRepo->first('logo')->value, function ($logo) use ($request, &$data) {
            foreach ($request->logo ?? [] as $type => $item) {
                if (! is_null($item)) {
                    $oldPath = $logo->$type;
                    if ($type == 'favicon') {
                        $newPath = $this->uploadImage($item, ['dir' => 'images/logo', 'height' => '46', 'width' => '46']);
                    } else {
                        $newPath = $this->uploadImage($item, ['dir' => 'images/logo', 'height' => '66', 'width' => '250']);
                    }

                    if ($newPath) {
                        if (file_exists(public_path($oldPath))) {
                            unlink(\public_path($oldPath));
                        }
                        $logo->$type = $newPath;
                    }
                }
            }
            $data['logo'] = $logo;
        });
        $settingsRepo->setMany($data);

        return redirect()->back()->with('success', 'Settings Saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
