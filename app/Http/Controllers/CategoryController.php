<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Foodcategory;
use App\Food;
use App\Setting;
use Illuminate\Support\Facades\Validator;
use Redirect;
use PDF;
use PHPExcel;
use PHPExcel_Cell;
use Maatwebsite\Excel\Facades\Excel as Excel;


class CategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$categories = Foodcategory::all();
    	return view('category.index',compact('categories'));
    }

    public function create(){
    	return view('category.create');
    }

    public function report(){
        return view('category.report');
    }

    public function getreport(Request $request){
        if($request->type == 'excel'){
        Excel::create('Food Categories Report', function($excel) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Food Categories Report', function($sheet){
              $foodcategories = Foodcategory::all();
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
              'FOOD CATEGORIES'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'NAME'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($foodcategories); $i++){
            
             $sheet->row($row, array(
             ($i+1),$foodcategories[$i]->name
             ));
             $row++;
             }             
             
    });

  })->download('xls');
        }else{
        $foodcategories = Foodcategory::all();
        $organization = Setting::find(1);
        $view = \View::make('category.viewreport',compact('foodcategories','organization'));
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
        PDF::SetTitle('Food Categories');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('food categories.pdf');
        }
    }

    public function individualreport($id){
        return view('category.individualreport',compact('id'));
    }

    public function getindividualreport(Request $request, $id){
        if($request->type == 'excel'){
        $foodcategory = Foodcategory::find($id);
        Excel::create($foodcategory->name.' Report', function($excel) use($foodcategory) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet($foodcategory->name.' Report', function($sheet) use($foodcategory){
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
              $foodcategory->name.' Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'NAME : ',$foodcategory->name 
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
                 
             
    });

  })->download('xls');
        }else{
        $foodcategory = Foodcategory::find($id);
        $organization = Setting::find(1);
        $view = \View::make('category.viewindividualreport',compact('foodcategory','organization'));
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
        PDF::SetTitle($foodcategory->name);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output($foodcategory->name.'.pdf');
        }
    }

    public function store(Request $request){

        /*$validator = Validator::make($data = $request->all(), Foodcategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}*/

    	$category = new Foodcategory;

		$category->name  = $request->name;

		$category->save();

        return Redirect::to('category')->withFlashMessage('Food category successfully created!');
	}

	public function show($id){
    	$category = Foodcategory::find($id);
    	return view('category.show',compact('category'));
    }

	public function edit($id){
    	$category = Foodcategory::find($id);
    	return view('category.edit',compact('category'));
    }

    public function update(Request $request,$id){

        /*$validator = Validator::make($data = $request->all(), Foodcategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}*/

    	$category = Foodcategory::find($id);

		$category->name  = $request->name;

		$category->update();

        return Redirect::to('category')->withFlashMessage('Food category successfully updated!');
	}

	public function destroy($id){
    	$category = Food::where('foodcategory_id',$id)->count();
		if($category>0){
			return Redirect::to('category')->withDeleteMessage('Cannot delete this food category because its linked to a food(s)!');
		}else{
		Foodcategory::destroy($id);

		return Redirect::to('category')->withFlashMessage('Food category successfully deleted!');
	}
    }

    public function foodtemplate($id){
        $foods = Food::where('foodcategory_id',$id)->get();
        $foodcategory = Foodcategory::where('id',$id)->first();
        return view('waiter.foodtemplate',compact('foods','foodcategory'));
    }

    public function getprices(Request $request){
        $food = Food::where('id',$request->id)->first();
        if($request->value == 'normal'){
            return $food->normal;
        }else if($request->value == 'small'){
            return $food->small;
        }else if($request->value == 'medium'){
            return $food->medium;
        }else if($request->value == 'large'){
            return $food->large;
        }
    }

    public function results(){
        return view('waiter.results');
    }
}
