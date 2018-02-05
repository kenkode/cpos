<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;
use App\Foodcategory;
use App\Order;
use App\Orderitem;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use App\User;
use PDF;
use PHPExcel;
use PHPExcel_Cell;
use Maatwebsite\Excel\Facades\Excel as Excel;

class AdminController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	return view('admin.index');
    }

    public function summary(){
            $users = User::where('role','waiter')->get();
            
            return view('admin.summary',compact('users'));
    }

    public function foodtemplate($id){
        $foods = Food::where('foodcategory_id',$id)->get();
        $foodcategory = Foodcategory::where('id',$id)->first();
        return view('admin.foodtemplate',compact('foods','foodcategory'));
    }

    public function orders(){
      $orders = Order::orderBy('id','DESC')->get();
      return view('admin.orders',compact('orders'));
    }

    public function payments(){
      $orders = Order::orderBy('id','DESC')->where('is_paid',1)->get();
      return view('admin.payments',compact('orders'));
    }

    public function report(){
        return view('admin.report');
    }

    public function getreport(Request $request){
        if($request->type == 'excel'){

        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 23:59:59');

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

              $sheet->mergeCells('A3:K3');
              $sheet->row(3, array(
              'ORDERS REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'ORDER NO.', 'DATE', 'AMOUNT', 'STATUS', 'PAID', 'TRANSACTED BY', 'CANCELLED BY'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $total = 0;
             
             
             for($i = 0; $i<count($orders); $i++){

            $status = '';
            $paid   = '';
            $cancel = '';
            $total = $total + Orderitem::getAmount($orders[$i]->id);

            if($orders[$i]->is_cancelled == 1 ){
            $status = 'Cancelled';
            }else {
            $status = 'Complete';
            }

            if($orders[$i]->is_paid == 1){
            $paid='Paid';
            }else{
            $paid='Reversed';
            }


            if($orders[$i]->is_cancelled == 1){
            $cancel = User::getUser($orders[$i]->cancel_id);
            }else{
            $cancel = '';
            }
            
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),Orderitem::getAmount($orders[$i]->id),$status,$paid,User::getUser($orders[$i]->waiter_id),$cancel
             ));
             $row++;
             }

             $sheet->row($row, array(
             '','','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

            });             
             
    });

  })->download('xls');

        }else{
        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->get();
        $organization = Setting::find(1);
        $view = \View::make('admin.viewreport',compact('orders','organization','f','t'));
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
        return view('admin.individualreport',compact('id'));
    }

    public function getindividualreport(Request $request, $id){
        if($request->type == 'excel'){
 
        $order = Order::find($id);

        Excel::create($order->order_no.'_Report_', function($excel) use ($order,$id) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet($order->order_no.' Report', function($sheet) use ($order,$id){
              $orderitems = Orderitem::where('order_id',$id)->get();
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $s = '';

              if(Order::getOrder($id)->is_cancelled == 1){
              $s = 'Cancelled';
              }else {
              $s = 'Complete';
              }

              $sheet->mergeCells('A3:I3');
              $sheet->row(3, array(
              $order->order_no.' REPORT STATUS: '.$s
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A4:I4');
              $sheet->row(4, array(
              'STATUS: '.$s
              ));

              $sheet->row(4, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              '#', 'NAME', 'CATEGORY', 'SIZE', 'DATE', 'QUANTITY', 'AMOUNT', 'TOTAL', 'STATUS'
              ));

              $sheet->row(6, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 7;
            $quantity=0; 
            $amount=0; 
            $total=0;
             
             
             for($i = 0; $i<count($orderitems); $i++){

            $status = '';
            $quantity = $quantity + $orderitems[$i]->quantity;
            $amount   = $amount   + $orderitems[$i]->amount;
            $total    = $total    + ($orderitems[$i]->quantity * $orderitems[$i]->amount);

            if(Order::getOrder($id)->is_cancelled == 1){
            $status = 'Cancelled';
            }else {
            $status = 'Complete';
            }

            
             $sheet->row($row, array(
             ($i+1),Food::getFood($orderitems[$i]->food_id)->name,Foodcategory::getName($orderitems[$i]->food_id),$orderitems[$i]->size,date('d-M-Y',strtotime($orderitems[$i]->created_at)),$orderitems[$i]->quantity,number_format($orderitems[$i]->amount,2),number_format($orderitems[$i]->amount * $orderitems[$i]->quantity,2),$status
             ));
             $row++;
             }

             $sheet->row($row, array(
             '','','','','Total',$quantity,$amount,$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

            });             
             
    });

  })->download('xls');

        }else{
        $order = Order::find($id);
        $orderitems = Orderitem::where('order_id',$id)->get();
        $organization = Setting::find(1);
        $view = \View::make('admin.viewindividualreport',compact('order','orderitems','id','organization'));
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
        PDF::AddPage('L');
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output($order->order_no.'.pdf');
        }
    }

    public function paymentsreport(){
        return view('admin.paymentsreport');
    }

    public function getpaymentsreport(Request $request){
        if($request->type == 'excel'){

        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        Excel::create('Payments_Report_'.$f.'_'.$t, function($excel) use ($from, $to, $f, $t) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Payments Report', function($sheet) use ($from, $to, $f, $t){
              $orders = Order::orderBy('id','DESC')->where('is_paid',1)->whereBetween('created_at', array($from, $to))->get();
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:H3');
              $sheet->row(3, array(
              'PAYMENTS REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'ORDER NO.', 'DATE', 'AMOUNT', 'PAYMENT METHOD', 'TRANSACTION NUMBER', 'AMOUNT PAID', 'TRANSACTED BY'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $total = 0;
             
             
             for($i = 0; $i<count($orders); $i++){
             $total = $total + Orderitem::getAmount($orders[$i]->id);
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),Orderitem::getAmount($orders[$i]->id),$orders[$i]->payment_method,$orders[$i]->transaction_number,$orders[$i]->amount_paid,User::getUser($orders[$i]->waiter_id)
             ));
             $row++;
             }

             $sheet->row($row, array(
             '','','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

            });             
             
    });

  })->download('xls');

        }else{
        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        $orders = Order::orderBy('id','DESC')->where('is_paid',1)->whereBetween('created_at', array($from, $to))->get();
        $organization = Setting::find(1);
        $view = \View::make('admin.viewpaymentsreport',compact('orders','organization','f','t'));
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
        PDF::SetTitle('Payments');
        PDF::AddPage('L');
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('payments_'.$f.'_'.$t.'.pdf');
        }
    }

    public function orderitems($id){
      
      $orderitems = Orderitem::where('order_id',$id)->get();
      return view('admin.show',compact('orderitems','id'));
    }

    public function cancelorderitem($id){
      $order = Orderitem::find($id);
      $order->is_cancelled = 1;
      $order->cancel_id = Auth::user()->id;
      $order->update();

      return redirect()->back()->withFlashMessage('Order Item Successfully Cancelled!');
    }

    public function returnorderitem($id){
      $order = Orderitem::find($id);
      $order->is_cancelled = 0;
      $order->cancel_id = null;
      $order->update();

      return redirect()->back()->withFlashMessage('Order Item Successfully Returned!');
    }

    public function summaryreport(){
        return view('admin.summaryreport');
    }

    public function getsummaryreport(Request $request){
        if($request->type == 'excel'){

        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        Excel::create('Summary_Report_'.$f.'_'.$t, function($excel) use ($from, $to, $f, $t) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Summary Report', function($sheet) use ($from, $to, $f, $t){
            $users = User::where('role','waiter')->get();

            $organization = Setting::find(1);
               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:F3');
              $sheet->row(3, array(
              'SUMMARY REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#','WAITER','TOTAL ORDERS', 'CANCELLED ORDERS', 'TOTAL AMOUNT HELD'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $orders=0; 
            $pending=0; 
            $completed=0; 
            $cancelled=0; 
            $paid=0; 
            $unpaid=0; 
            $total=0;
            

             for($i=0; $i<count($users); $i++) {

                  $orders = $orders + User::getRangeOrders($users[$i]->id,$from,$to);
                  $cancelled = $cancelled + User::getRangeCancelled($users[$i]->id,$from,$to);
                  $total = $total + User::getRangeAmount($users[$i]->id,$from,$to);
                
            
             $sheet->row($row, array(
             ($i+1),$users[$i]->name,User::getRangeOrders($users[$i]->id,$from,$to),User::getRangeCancelled($users[$i]->id,$from,$to),User::getRangeAmount($users[$i]->id,$from,$to)
             ));
             $row++;
             }

             $sheet->row($row, array(
             '','Total',$orders,$cancelled,$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

            });       

             
    });

  })->download('xls');

        }else{
        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        $users = User::where('role','waiter')->get();
        $organization = Setting::find(1);
        $view = \View::make('admin.viewsummaryreport',compact('users','organization','f','t','from','to'));
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
        PDF::SetTitle('Summary');
        PDF::AddPage('L');
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('summary_'.$f.'_'.$t.'.pdf');
        }
    }


}
