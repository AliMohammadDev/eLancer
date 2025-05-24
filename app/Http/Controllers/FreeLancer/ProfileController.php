<?php

namespace App\Http\Controllers\FreeLancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('freelancer.profile.edit', [
            'user' => $user,
            'profile' => $user->freeLancer,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
        ]);

        $user = Auth::user();

        $user->freeLancer()
            ->updateOrCreate(
                ['user_id' => $user->id],
                $request->all()
            );
        // $user->name = $request->first_name . '' . $request->last_name;
        // $user->save();
        $user->forceFill([
            $user->name = $request->first_name.''.$request->last_name,
        ])->save();

        return redirect()->route('freelancer.profile.edit')
            ->with('Success', 'Profile Updated');
    }
}
