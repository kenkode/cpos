<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Redirect;
use PDF;
use App\Setting;
use App\Order;
use App\Orderitem;
use PHPExcel;
use PHPExcel_Cell;
use Maatwebsite\Excel\Facades\Excel as Excel;


class RevenuesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$orders = Order::where('is_paid',1)->where('is_cancelled',0)->get();
    	return view('admin.revenues',compact('orders'));
    }

    public function report(){
        return view('admin.revenuereport');
    }

    public function getreport(Request $request){
        if($request->type == 'excel'){

        Excel::create('Revenue Report', function($excel) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Revenue Report', function($sheet){
              $orders = Order::where('is_paid',1)->where('is_cancelled',0)->get();
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:E3');
              $sheet->row(3, array(
              'Revenues'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'ORDER NO.', 'AMOUNT (KSH.)', 'REVENUE (KSH.)', 'TAX (KSH.)'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             $total = 0;
             $totalrevenue = 0;
             $totaltax = 0;
             
             for($i = 0; $i<count($orders); $i++){
              $total = $total + Orderitem::getAmount($orders[$i]->id); 
              $totalrevenue = $totalrevenue + (Orderitem::getAmount($orders[$i]->id) - (Orderitem::getAmount($orders[$i]->id) * 0.16)); 
              $totaltax = $totaltax + (Orderitem::getAmount($orders[$i]->id) * 0.16); 
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,Orderitem::getAmount($orders[$i]->id),(Orderitem::getAmount($orders[$i]->id) - (Orderitem::getAmount($orders[$i]->id) * 0.16)), (Orderitem::getAmount($orders[$i]->id) * 0.16)
             ));
             $row++;
             } 

             $sheet->row($row, array(
             '','Total',$total,$totalrevenue,$totaltax
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

            });                  
    });

  })->download('xls');

        }else{
        $orders = Order::where('is_paid',1)->where('is_cancelled',0)->get();
        $organization = Setting::find(1);
        $view = \View::make('admin.viewrevenuereport',compact('orders','organization'));
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
        PDF::SetTitle('Revenues');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('revenues.pdf');
        }
    }

    public function individualreport($id){
        return view('admin.individualrevenuereport',compact('id'));
    }

    public function getindividualreport(Request $request, $id){
        if($request->type == 'excel'){

        $order = Order::find($id);
        Excel::create($order->order_no.' Report', function($excel) use($order) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet($order->order_no.' Report', function($sheet) use($order){
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'ORGANIZATION : ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:B3');
              $sheet->row(3, array(
              $order->order_no.' REPORT'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'ORDER NO : ',$order->order_no 
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'AMOUNT (KSH.) : ',Orderitem::getAmount($order->id)
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'REVENUE (KSH.) : ',(Orderitem::getAmount($order->id) - (Orderitem::getAmount($order->id) * 0.16))
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(7, array(
              'TAX (KSH.) : ',(Orderitem::getAmount($order->id) * 0.16)
              ));

              $sheet->cell('A7', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });   
    });

  })->download('xls');

        }else{
        $order = Order::find($id);
        $organization = Setting::find(1);
        $view = \View::make('admin.viewindividualrevenuereport',compact('order','organization'));
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
        PDF::SetTitle($order->order_no);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output($order->order_no.'.pdf');
        }
    }

	public function show($id){
      $order = Order::find($id);
    	return view('admin.revenueshow',compact('order'));
    }
}
