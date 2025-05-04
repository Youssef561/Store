<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Locales;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();               // we did not pass the parameter id on edit function caz we already now the user who want to edit his profile

        $countries = Countries::getNames();
        $locales = Locales::getNames();

        return view('dashboard.profile.edit', compact('user', 'countries', 'locales'));
    }


    public function update(Request $request){

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required', 'string', 'size:2'],
            'locale' => ['required', 'string', 'min:2'],
            //'locale' => ['required', Rule::in(Locales::getLocales())],
        ]);

        $user = $request->user();

        $profileData = $request->all();
        $profileData['locale'] = substr($profileData['locale'], 0, 2);      // some locales have more than 2 char so we use substr

        $user->profile->fill($profileData)->save();          // fill -> update if there is a record already and create if there is no record

//        $profile = $user->profile;
//        // we cannot use inside if only $profile caz it always return true caz we use withDefault in the model which is return object everytime, and we use first_name for ex
//        if($profile->first_name){
//            $user->profile->update($request->all());
//        }else{
//            $request->merge([             // we use merge caz there is no user_id from the request, the request has id not user_id
//                'user_id' => $user->id
//           ]);
//           Profile::create($request->all());
//
//            $user->profile()->create($request->all());          // this line instead of the commented code and the id will go to user_id automatically caz there is a relation between both
//
//        }


        return redirect()->route('profile.edit')
            ->with('success','Profile updated successfully');
    }


}
