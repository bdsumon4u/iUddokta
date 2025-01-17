<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (! $request->isMethod('GET')) {
            Notice::query()->update([
                'content' => $request->input('content'),
            ]);
        }

        return view('admin.notices.index', [
            'notice' => Notice::query()->firstOrCreate(),
        ]);
    }
}
