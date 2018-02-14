<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Redirect;
use PDF;
use PHPExcel;
use PHPExcel_Cell;
use Maatwebsite\Excel\Facades\Excel as Excel;

class SettingsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$setting = Setting::find(1);
    	return view('settings.index',compact('setting'));
    }

    public function individualreport($id){
        return view('settings.individualreport',compact('id'));
    }

    public function getindividualreport(Request $request){
        if($request->type == 'excel'){

        $organization = Setting::find(1);
        Excel::create($organization->name.' Report', function($excel) use($organization) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet($organization->name.' Report', function($sheet) use($organization){

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:B3');
              $sheet->row(3, array(
              $organization->name.' Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'NAME : ',$organization->name 
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'ADDRESS : ',$organization->address 
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'TEL # : ',$organization->phone 
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(7, array(
              'KRA PIN : ',$organization->pin 
              ));

              $sheet->cell('A7', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'VAT # : ',$organization->vat_no 
              ));

              $sheet->cell('A8', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(9, array(
              'VAT : ',$organization->vat.'%' 
              ));

              $sheet->cell('A9', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(10, array(
              'KRA/ETR : ',$organization->kra_etr 
              ));

              $sheet->cell('A10', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(11, array(
              'SERIAL # : ',$organization->serial_no 
              ));

              $sheet->cell('A11', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(12, array(
              'FOOT NOTE : ',$organization->receipt_footer 
              ));

              $sheet->cell('A12', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
 
    });

  })->download('xls');

        }else{
        $organization = Setting::find(1);
        $view = \View::make('settings.viewindividualreport',compact('organization'));
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
        PDF::SetTitle('Organization');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output($organization->name.'.pdf');
        }
    }

    public function update(Request $request){

        /*$validator = Validator::make($data = $request->all(), Foodcategory::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}*/

    	$setting = Setting::find(1);

    	if ( $request->hasFile('image')) {

            $file = $request->file('image');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('images', $name);
            $input['file'] = '/images'.$name;
            $setting->logo = $name;
        }

		$setting->name  = $request->name;
    $setting->address  = $request->address;
    $setting->phone  = $request->phone;
    $setting->pin  = $request->pin;
    $setting->vat_no  = $request->vat_no;
    $setting->vat  = $request->vat;
    $setting->kra_etr  = $request->kra_etr;
    $setting->serial_no  = $request->serial_no;
		$setting->receipt_footer  = $request->receipt;

		$setting->update();

        return Redirect::to('setting')->withFlashMessage('Settingd successfully updated!');
	}

}
