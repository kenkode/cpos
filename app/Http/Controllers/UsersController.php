<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Redirect;
use Auth;
use App\Setting;
use PDF;
use PHPExcel;
use PHPExcel_Cell;
use Maatwebsite\Excel\Facades\Excel as Excel;

class UsersController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$users = User::all();
    	return view('users.index',compact('users'));
    }

    public function create(){
    	return view('users.create');
    }

    public function report(){
        return view('users.report');
    }

    public function getreport(Request $request){
        if($request->type == 'excel'){

        Excel::create('Users Report', function($excel) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Users Report', function($sheet){
              $users = User::all();
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:B3');
              $sheet->row(3, array(
              'USERS'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'NAME', 'EMAIL', 'ROLE', 'STATUS'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($users); $i++){

            $status = '';
            $role = '';

            if($users[$i]->status == 1 ){
            $status = 'Active';
            }else{
            $status = 'Disabled';
            }

            if($users[$i]->role == 'waiter' ){
            $role = 'Cashier';
            }else{
            $role = 'Admin';
            }
            
             $sheet->row($row, array(
             ($i+1),$users[$i]->name,$users[$i]->email,$role,$status
             ));
             $row++;
             }             
             
    });

  })->download('xls');

        }else{
        $users = User::all();
        $organization = Setting::find(1);
        $view = \View::make('users.viewreport',compact('users','organization'));
        $html = $view->render();

        PDF::setFooterCallback(function($pdf) {

        // Position at 15 mm from bottom
        $pdf->SetY(-15);
        // Set font
        $pdf->SetFont('helvetica', 'I', 8);
        // Page number
        $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });

        //$pdf = new TCPDF();
        PDF::SetTitle('System Users');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('users.pdf');
        }
    }

    public function individualreport($id){
        return view('users.individualreport',compact('id'));
    }

    public function getindividualreport(Request $request, $id){
        if($request->type == 'excel'){

        $user = User::find($id);
        Excel::create($user->name.' Report', function($excel) use($user) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet($user->name.' Report', function($sheet) use($user){
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:B3');
              $sheet->row(3, array(
              $user->name.' Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'NAME : ',$user->name 
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'EMAIL : ',$user->email 
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $role = '';

              if($user->role == 'waiter' ){
            $role = 'Cashier';
            }else{
            $role = 'Admin';
            }

              $sheet->row(6, array(
              'ROLE : ',$role 
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $status = '';

            if($user->status == 1 ){
            $status = 'Active';
            }else{
            $status = 'Disabled';
            }

            

              $sheet->row(7, array(
              'STATUS : ',$status
              ));

              $sheet->cell('A7', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
             
    });

  })->download('xls');

        }else{
        $user = User::find($id);
        $organization = Setting::find(1);
        $view = \View::make('users.viewindividualreport',compact('user','organization'));
        $html = $view->render();

        PDF::setFooterCallback(function($pdf) {

        // Position at 15 mm from bottom
        $pdf->SetY(-15);
        // Set font
        $pdf->SetFont('helvetica', 'I', 8);
        // Page number
        $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });

        //$pdf = new TCPDF();
        PDF::SetTitle($user->name);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output($user->name.'.pdf');
        }
    }

    public function store(Request $request){

        /*$validator = Validator::make($data = $request->all(), Foodcategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}*/

    	$user = new User;

        if ( $request->hasFile('image')) {

            $file = $request->file('image');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('images', $name);
            $input['file'] = '/images'.$name;
            $user->photo = $name;
        }

		$user->name  = $request->name;
        $user->email  = $request->email;
        $user->role  = $request->role;
        $user->status  = 1;
        $user->password = bcrypt($request->password);
        
		$user->save();

        return Redirect::to('users')->withFlashMessage('User successfully created!');
	}

	public function show($id){
		$user = User::find($id);
    	return view('users.show',compact('user'));
    }

    public function edit($id){
		$user = User::find($id);
    	return view('users.edit',compact('user'));
    }

    public function update(Request $request,$id){

        /*$validator = Validator::make($data = $request->all(), Foodcategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}*/

    	$user = User::find($id);

        if ( $request->hasFile('image')) {

            $file = $request->file('image');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('images', $name);
            $input['file'] = '/images'.$name;
            $user->photo = $name;
        }

		$user->name  = $request->name;
        $user->email  = $request->email;
        $user->role  = $request->role;
        
		$user->update();

        return Redirect::to('users')->withFlashMessage('User successfully updated!');
	}

	public function activate($id){
    	
		$user = User::find($id);

		$user->status  = 1;
        
		$user->update();

		return Redirect::to('users')->withFlashMessage('User successfully activated!');
	
    }

    public function deactivate($id){
    	
    	if(Auth::user()->id == $id){
    		return redirect()->back()->withDeleteMessage('You cant deactivate yourself!');
    	}

		$user = User::find($id);

		$user->status  = 0;
        
		$user->update();

		return Redirect::to('users')->withFlashMessage('User successfully deactivated!');
	
    }

    public function changepassword($id){
		$user = User::find($id);
    	return view('users.editpassword',compact('user'));
    }

    public function updatepassword(Request $request,$id){

        /*$validator = Validator::make($data = $request->all(), Foodcategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}*/

    	$user = User::find($id);
    
        $pass = bcrypt($request->password);

        $user->password  = $pass;

		$user->update();

        return Redirect::to('users')->withFlashMessage('Password successfully updated');

	}

	public function destroy($id){
    	
		User::destroy($id);

		return Redirect::to('users')->withFlashMessage('User successfully deleted!');
	
    }
}
