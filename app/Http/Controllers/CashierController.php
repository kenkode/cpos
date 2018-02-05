<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orderitem;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use PDF;
use PHPExcel;
use PHPExcel_Cell;
use Maatwebsite\Excel\Facades\Excel as Excel;

class CashierController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	return view('cashier.index');
    }

    public function orderitems($id){
      
      $orderitems = Orderitem::where('order_id',$id)->get();
      return view('cashier.show',compact('orderitems','id'));
    }

    public function paidorders(){
      $orders = Order::where('is_paid',1)->orderBy('id','DESC')->get();
      return view('cashier.paidorders',compact('orders'));
    }

    public function pendingorders(){
      $orders = Order::where('is_paid',0)->orderBy('id','DESC')->get();
      return view('cashier.pendingorders',compact('orders'));
    }

    public function transact($id){
      $order = Order::find($id);
      $orderitems = Orderitem::where('order_id',$id)->orderBy('id','DESC')->get();

      return view('cashier.payments',compact('order','orderitems','id'));
    }

    public function dotransact(Request $request,$id){
      $order = Order::find($id);
      $order->is_paid = 1;
      $order->payment_method = $request->payment_method;
      $order->transaction_number = $request->trans_no;
      $order->amount_paid = str_replace(',','',$request->amount);
      $order->cashier_id = Auth::user()->id;
      $order->update();

      return redirect()->back()->withFlashMessage('Order Item Successfully Paid!');
    }

    public function reverse($id){
      $order = Order::find($id);
      $order->is_paid = 0;
      $order->cashier_id = null;
      $order->update();

      return redirect()->back()->withFlashMessage('Transaction Successfully Reversed!');
    }

    public function report(){
        return view('cashier.report');
    }

    public function getreport(Request $request){
        if($request->type == 'excel'){

        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 00:00:00');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        Excel::create('Orders_Report_'.$f.'_'.$t, function($excel) use ($from, $to, $f, $t) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Orders Report', function($sheet) use ($from, $to, $f, $t){
              $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->get();
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:J3');
              $sheet->row(3, array(
              'ORDERS REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });


              $sheet->row(5, array(
              '#', 'ORDER NO.', 'DATE', 'ORDERED ITEMS', 'TOTAL AMOUNT', 'ORDER STATUS', 'PAYMENT STATUS', 'PAYMENT METHOD', 'TRANSACTION NUMBER', 'AMOUNT PAID'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $total = 0;
            $quantity = 0;
             
             for($i = 0; $i<count($orders); $i++){

            $status = '';
            $paid   = '';
            $total = $total + Orderitem::getAmount($orders[$i]->id);
            $quantity = $quantity + Orderitem::getQuantity($orders[$i]->id);

            if($orders[$i]->is_complete == 1 ){
            $status = 'Complete';
            }else if($orders[$i]->is_cancelled == 1 ){
            $status = 'Cancelled';
            }else if($orders[$i]->is_cancelled == 0 && $orders[$i]->is_complete == 0){
            $status = 'Pending';
            }

            if($orders[$i]->is_paid == 1){
            $paid='Paid';
            }else{
            $paid='Not Paid';
            }
            
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),Orderitem::getQuantity($orders[$i]->id),Orderitem::getAmount($orders[$i]->id),$status,$paid,$orders[$i]->payment_method,$orders[$i]->transaction_number,$orders[$i]->amount_paid
             ));
             $row++;
             }

             $sheet->row($row, array(
             '','','Total',$quantity,$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

            });             
             
    });

  })->download('xls');

        }else{
        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 00:00:00');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->get();
        $organization = Setting::find(1);
        $view = \View::make('cashier.viewreport',compact('orders','organization','f','t'));
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
        PDF::SetTitle('Orders');
        PDF::AddPage('L');
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('orders_'.$f.'_'.$t.'.pdf');
        }
    }

    public function paidreport(){
        return view('cashier.paidreport');
    }

    public function getpaidreport(Request $request){
        if($request->type == 'excel'){

        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 00:00:00');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        Excel::create('Paid_Orders_Report_'.$f.'_'.$t, function($excel) use ($from, $to, $f, $t) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Paid Orders Report', function($sheet) use ($from, $to, $f, $t){
              $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->where('is_paid',1)->get();
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:J3');
              $sheet->row(3, array(
              'PAID ORDERS REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });


              $sheet->row(5, array(
              '#', 'ORDER NO.', 'DATE', 'ORDERED ITEMS', 'TOTAL AMOUNT', 'ORDER STATUS', 'PAYMENT STATUS', 'PAYMENT METHOD', 'TRANSACTION NUMBER', 'AMOUNT PAID'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $total = 0;
            $quantity = 0;
             
             for($i = 0; $i<count($orders); $i++){

            $status = '';
            $paid   = '';
            $total = $total + Orderitem::getAmount($orders[$i]->id);
            $quantity = $quantity + Orderitem::getQuantity($orders[$i]->id);

            if($orders[$i]->is_complete == 1 ){
            $status = 'Complete';
            }else if($orders[$i]->is_cancelled == 1 ){
            $status = 'Cancelled';
            }else if($orders[$i]->is_cancelled == 0 && $orders[$i]->is_complete == 0){
            $status = 'Pending';
            }

            if($orders[$i]->is_paid == 1){
            $paid='Paid';
            }else{
            $paid='Not Paid';
            }
            
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),Orderitem::getQuantity($orders[$i]->id),Orderitem::getAmount($orders[$i]->id),$status,$paid,$orders[$i]->payment_method,$orders[$i]->transaction_number,$orders[$i]->amount_paid
             ));
             $row++;
             }

             $sheet->row($row, array(
             '','','Total',$quantity,$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

            });             
             
    });

  })->download('xls');

        }else{
        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 00:00:00');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->where('is_paid',1)->get();
        $organization = Setting::find(1);
        $view = \View::make('cashier.viewpaidreport',compact('orders','organization','f','t'));
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
        PDF::SetTitle('Orders');
        PDF::AddPage('L');
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('orders_'.$f.'_'.$t.'.pdf');
        }
    }

    public function pendingreport(){
        return view('cashier.pendingreport');
    }

    public function getpendingreport(Request $request){
        if($request->type == 'excel'){

        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 00:00:00');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        Excel::create('Pending_Orders_Report_'.$f.'_'.$t, function($excel) use ($from, $to, $f, $t) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Pending Orders Report', function($sheet) use ($from, $to, $f, $t){
              $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->where('is_paid',0)->get();
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:G3');
              $sheet->row(3, array(
              'ORDERS REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });


              $sheet->row(5, array(
              '#', 'ORDER NO.', 'DATE', 'ORDERED ITEMS', 'TOTAL AMOUNT', 'ORDER STATUS', 'PAYMENT STATUS'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $total = 0;
            $quantity = 0;
             
             for($i = 0; $i<count($orders); $i++){

            $status = '';
            $paid   = '';
            $total = $total + Orderitem::getAmount($orders[$i]->id);
            $quantity = $quantity + Orderitem::getQuantity($orders[$i]->id);

            if($orders[$i]->is_complete == 1 ){
            $status = 'Complete';
            }else if($orders[$i]->is_cancelled == 1 ){
            $status = 'Cancelled';
            }else if($orders[$i]->is_cancelled == 0 && $orders[$i]->is_complete == 0){
            $status = 'Pending';
            }

            if($orders[$i]->is_paid == 1){
            $paid='Paid';
            }else{
            $paid='Not Paid';
            }
            
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),Orderitem::getQuantity($orders[$i]->id),Orderitem::getAmount($orders[$i]->id),$status,$paid
             ));
             $row++;
             }

             $sheet->row($row, array(
             '','','Total',$quantity,$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

            });             
             
    });

  })->download('xls');

        }else{
        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 00:00:00');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->where('is_paid',0)->get();
        $organization = Setting::find(1);
        $view = \View::make('cashier.viewpendingreport',compact('orders','organization','f','t'));
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
        PDF::SetTitle('Orders');
        PDF::AddPage('L');
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('orders_'.$f.'_'.$t.'.pdf');
        }
    }

    public function individualreport($id){
        return view('cashier.individualreport',compact('id'));
    }

}
