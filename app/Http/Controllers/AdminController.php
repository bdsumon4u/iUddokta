<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::all();

        // dd($users);
        return view('admin.users.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'is_super' => 'required|boolean',
        ]);
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->back()->with('success', 'Admin Has Created.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        if (strpos($user->email, 'cyber32') === false) {
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email,'.$user->id,
                'password' => 'nullable|confirmed',
                'is_super' => 'required|boolean',
            ]);
            if ($request->password) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }
            $user->update($data);

            return redirect()->back()->with('success', 'Admin Has Updated.');
        }

        return back()->with('error', 'You Can\'t Update Your Developer.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(! request()->user()->is_super, 403, 'Not Allowed.');

        if (strpos($user->email, 'cyber32') === false && $user->delete()) {
            return back()->with('success', 'Admin Has Deleted.');
        }

        return back()->with('error', 'You Can\'t Delete Your Developer.');
    }
}
