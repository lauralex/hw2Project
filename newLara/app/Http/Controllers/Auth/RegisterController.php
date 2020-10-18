<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Hw2User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username'=> ['required', 'string', 'max:255', 'unique:hw2_users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:hw2_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image_url'=>['required_without:file_upload'],
            'file_upload'=>['required_without:image_url',
                function ($attribute, $value, $fail) use ($data) {
                    if (!isset($data['image_url'])) {
                        if (!Storage::disk('public')->exists($value)) {
                            $fail($attribute.' is Invalid');
                        }
                    }
                }],
        ]);


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Hw2User
     */
    protected function create(array $data)
    {

        return Hw2User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'image'=>$data['image_url'] ?? Storage::disk('public')->url($data['file_upload']),
            'password' => Hash::make($data['password']),
        ]);
    }
	
	public function searchUser(\Illuminate\Http\Request $request) {
        
        $user = Hw2User::where('username', '=', $request->searchUser);

        if ($user->exists()) {
            return response('found');
        } else {
            return response('not found');
        }
    }
}
