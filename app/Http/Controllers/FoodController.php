<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;
use App\Foodcategory;
use Redirect;
use PDF;
use App\Setting;
use PHPExcel;
use PHPExcel_Cell;
use Maatwebsite\Excel\Facades\Excel as Excel;


class FoodController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$foods = Food::all();
    	return view('food.index',compact('foods'));
    }

    public function create(){
        $foodcategories = Foodcategory::all();
    	return view('food.create',compact('foodcategories'));
    }

    public function report(){
        return view('food.report');
    }

    public function getreport(Request $request){
        if($request->type == 'excel'){

        Excel::create('Food Report', function($excel) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Food Report', function($sheet){
              $foods = Food::all();
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
              'FOOD'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'NAME', 'CATEGORY', 'NORMAL PRICE (KSH.)', 'SMALL SIZE PRICE (KSH.)', 'MEDIUM SIZE PRICE (KSH.)','LARGE SIZE PRICE (KSH.)'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($foods); $i++){
            
             $sheet->row($row, array(
             ($i+1),$foods[$i]->name,$foods[$i]->foodcategory->name,$foods[$i]->normal,$foods[$i]->small,$foods[$i]->medium,$foods[$i]->large
             ));
             $row++;
             }             
             
    });

  })->download('xls');

        }else{
        $foods = Food::all();
        $organization = Setting::find(1);
        $view = \View::make('food.viewreport',compact('foods','organization'));
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
        PDF::SetTitle('Food');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('food.pdf');
        }
    }

    public function individualreport($id){
        return view('food.individualreport',compact('id'));
    }

    public function getindividualreport(Request $request, $id){
        if($request->type == 'excel'){

        $food = Food::find($id);
        Excel::create($food->name.' Report', function($excel) use($food) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet($food->name.' Report', function($sheet) use($food){
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
              $food->name.' Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'NAME : ',$food->name 
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'CATEGORY : ',$food->foodcategory->name 
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'NORMAL PRICE (KSH.) : ',$food->normal 
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(7, array(
              'SMALL SIZE PRICE (KSH.) : ',$food->small 
              ));

              $sheet->cell('A7', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'MEDIUM SIZE PRICE (KSH.) : ',$food->medium 
              ));

              $sheet->cell('A8', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(9, array(
              'LARGE SIZE PRICE (KSH.) : ',$food->large 
              ));

              $sheet->cell('A9', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
                 
             
    });

  })->download('xls');

        }else{
        $food = Food::find($id);
        $organization = Setting::find(1);
        $view = \View::make('food.viewindividualreport',compact('food','organization'));
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
        PDF::SetTitle($food->name);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output($food->name.'.pdf');
        }
    }

    public function store(Request $request){

        /*$validator = Validator::make($data = $request->all(), Foodcategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}*/

    	$food = new Food;

        if ( $request->hasFile('image')) {

            $file = $request->file('image');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('images', $name);
            $input['file'] = '/images'.$name;
            $food->image = $name;
        }

		$food->name  = $request->name;
        $food->foodcategory_id  = $request->foodcategory;
        $food->normal  = str_replace(',','',$request->normalprice);
        $food->small  = str_replace(',','',$request->smallprice);
        $food->medium  = str_replace(',','',$request->mediumprice);
        $food->large  = str_replace(',','',$request->largeprice);

		$food->save();

        return Redirect::to('food')->withFlashMessage('Food successfully created!');
	}

	public function show($id){
        $food = Food::find($id);
    	return view('food.show',compact('food'));
    }

	public function edit($id){
    	$foodcategories = Foodcategory::all();
        $food = Food::find($id);
        return view('food.edit',compact('foodcategories','food'));
    }

    public function update(Request $request,$id){

        /*$validator = Validator::make($data = $request->all(), Foodcategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}*/

    	$food = Food::find($id);

		if ( $request->hasFile('image')) {

            $file = $request->file('image');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('images', $name);
            $input['file'] = '/images'.$name;
            $food->image = $name;
        }

        $food->name  = $request->name;
        $food->foodcategory_id  = $request->foodcategory;
        $food->normal  = str_replace(',','',$request->normalprice);
        $food->small  = str_replace(',','',$request->smallprice);
        $food->medium  = str_replace(',','',$request->mediumprice);
        $food->large  = str_replace(',','',$request->largeprice);

		$food->update();

        return Redirect::to('food')->withFlashMessage('Food successfully updated!');
	}

	public function destroy($id){
    	
		Food::destroy($id);

		return Redirect::to('food')->withFlashMessage('Food successfully deleted!');
	
    }
}
