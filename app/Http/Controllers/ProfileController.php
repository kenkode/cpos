<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Redirect;
use Auth;
use App\Order;

class ProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('profile.index');
    }
    public function edituser()
    {
        
        return view('profile.edituser');
    }
    public function changepassword()
    {
        
        return view('profile.editpassword');
    }

    public function admin()
    {
        
        return view('profile.admin');
    }
    public function editadmin()
    {
        
        return view('profile.editadmin');
    }
    public function adminpassword()
    {
        
        return view('profile.editadminpassword');
    }

    public function updateuser(Request $request){
    	$user = User::find(Auth::user()->id);

        if ( $request->hasFile('image')) {

            $file = $request->file('image');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('images', $name);
            $input['file'] = '/images'.$name;
            $user->photo = $name;
        }

		$user->name  = $request->name;

		$user->email = $request->email;

		$user->update();

        if($user->role == 'admin'){
          return Redirect::to('admin/profile')->withFlashMessage('Profile successfully updated!');
        }else{
           return Redirect::to('profile')->withFlashMessage('Profile successfully updated!'); 
        }

        
	}

	public function updatepassword(Request $request){
    	$user = User::find(Auth::user()->id);

    	$password_confirmation = $request->confirmpassword;
        $password = $request->newpassword;

        if (!password_verify($request->currentpassword, $user->password)){

            return Redirect::back()->withDeleteMessage('Current password inputed does not match your current password in the database!');
        }
        else if($password != $password_confirmation){

            return Redirect::back()->withDeleteMessage('Passwords do not match!');
        }  
        else
        {
    
        $pass = bcrypt($password);

        $user->password  = $pass;

		$user->update();

        if($user->role == 'admin'){
          return Redirect::to('admin/profile')->withFlashMessage('Password successfully updated');
        }else{
          return Redirect::to('profile')->withFlashMessage('Password successfully updated');
        }

        
            
        }
	}
}
