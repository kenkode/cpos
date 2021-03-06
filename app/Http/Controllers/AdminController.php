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
use Redirect;

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
            $users = User::all();
            
            return view('admin.summary',compact('users'));
    }

    public function usersummary($id){
            $user = User::find($id);
            
            return view('admin.usersummary',compact('user'));
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
      $orders = Order::orderBy('id','DESC')->get();
      return view('admin.payments',compact('orders'));
    }

    public function paymentCreate(){
        $orders = Order::orderBy('id','DESC')->where('is_paid',0)->get();
        return view('admin.paymentcreate',compact('orders'));
    }

    public function completeOrder($id){
        $order = Order::find($id);
        return view('admin.completetransaction',compact('order'));
    }

    public function paymentStore(Request $request){

    	$order = Order::find($request->order);

        if($request->mode != "Cash" && $request->mode != "Double Payment"){
          $order->payment_method = $request->mode;
          $order->transaction_number = $request->transaction_number;
          $order->is_double_payment = 0;
        }else if($request->mode == "Double Payment"){
          $order->payment_method = $request->mode_1.", ".$request->mode_2;
          $order->is_double_payment = 1;
          if($request->mode_1 == "Cash"){
            $order->amount_paid_by_cash = $request->amount_1;
          }else if($request->mode_1 == "Mpesa"){
            $order->amount_paid_by_mpesa = $request->amount_1;
          }else if($request->mode_1 == "Bank"){
            $order->amount_paid_by_mpesa = $request->amount_1;
          }

          if($request->mode_2 == "Cash"){
            $order->amount_paid_by_cash = $request->amount_2;
          }else if($request->mode_2 == "Mpesa"){
            $order->amount_paid_by_mpesa = $request->amount_2;
          }else if($request->mode_2 == "Bank"){
            $order->amount_paid_by_mpesa = $request->amount_2;
          }

          if($request->mode_1 != "Cash" && $request->mode_2 != "Cash"){
            $order->transaction_number = $request->transaction_number_1.", ".$request->transaction_number_2;
          }else{
            $order->transaction_number = $request->transaction_number_1.$request->transaction_number_2;
          }
        }
        $order->is_paid = 1;
        $order->payment_by = Auth::user()->id;
        $order->tax = 0.16 * $order->amount;
		    $order->update();

        return Redirect::to('/admin/orders/payments')->withFlashMessage('Order successfully paid!');
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
              '#', 'ORDER NO.', 'DATE', 'AMOUNT', 'STATUS', 'PAYMENT METHOD', 'TRANSACTION NUMBER', 'PAID', 'TRANSACTED BY', 'REVERSED BY', 'PAYMENT BY'
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

            if($orders[$i]->is_paid == 1 && $orders[$i]->is_cancelled == 0){
            $paid='Paid';
            }else if($orders[$i]->is_paid == 0 && $orders[$i]->is_cancelled == 0){
            $paid='Not Paid';
            }else{
            $paid='Reversed';
            }


            if($orders[$i]->is_cancelled == 1){
            $cancel = User::getUser($orders[$i]->cancel_id);
            }else{
            $cancel = '';
            }
            
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),Orderitem::getAmount($orders[$i]->id),$orders[$i]->payment_method,$orders[$i]->transaction_number,$status,$paid,User::getUser($orders[$i]->waiter_id),$cancel,User::getUser($orders[$i]->payment_by) ? User::getUser($orders[$i]->payment_by) : ''
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
              $s = 'Reversed';
              }else if(Order::getOrder($id)->is_paid == 1){
              $s = 'Paid';
              }else {
              $s = 'Complete';
              }

              $sheet->row(2, array(
              'ORDER NUMBER: ',$order->order_no
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'STATUS: ',$s
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell;
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PAYMENT BY: ',User::getUser(Order::getOrder($id)->payment_by) ? User::getUser(Order::getOrder($id)->payment_by) : ""
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
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
            $status = 'Reversed';
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

    public function client($id){
        return view('admin.client',compact('id'));
    }

    public function invoice(Request $request, $id){
        
        $order = Order::find($id);
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $addr = $request->address;
        $orderitems = Orderitem::where('order_id',$id)->get();
        $organization = Setting::find(1);
        $view = \View::make('admin.invoices',compact('order','orderitems','id','organization','name','phone','email','addr'));
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
        PDF::SetTitle('Invoice-'.$order->order_no);
        PDF::AddPage('p');
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('invoice_'.$order->order_no.'.pdf');
        
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

              $sheet->mergeCells('A3:G3');
              $sheet->row(3, array(
              'PAYMENTS REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'ORDER NO.', 'DATE', 'AMOUNT', 'PAYMENT METHOD', 'TRANSACTION NUMBER', 'TRANSACTED BY'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $total = 0;
            $amount = '';
             
             for($i = 0; $i<count($orders); $i++){
              if($orders[$i]->is_paid == 0 && $orders[$i]->is_cancelled == 0){
                $amount = 'Not Paid';
              }elseif($orders[$i]->is_cancelled == 1){
                $amount = 'Reversed';
              }else{
                $amount = number_format(Orderitem::getAmount($orders[$i]->id),2);
              }
             $total = $total + Orderitem::getAmount($orders[$i]->id);
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),$amount,$orders[$i]->payment_method,$orders[$i]->transaction_number,User::getUser($orders[$i]->waiter_id)
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
            $users = User::all();

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
              '#','USER','COMPLETED ORDERS', 'CANCELLED ORDERS', 'TOTAL ORDERS', 'TOTAL AMOUNT HELD'
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
                  $completed = $completed + User::getRangeCompleted($users[$i]->id,$from,$to);
                  $cancelled = $cancelled + User::getRangeCancelled($users[$i]->id,$from,$to);
                  $total = $total + User::getRangeAmount($users[$i]->id,$from,$to);
                
            
             $sheet->row($row, array(
             ($i+1),$users[$i]->name,User::getRangeCompleted($users[$i]->id,$from,$to),User::getRangeCancelled($users[$i]->id,$from,$to),User::getRangeOrders($users[$i]->id,$from,$to),User::getRangeAmount($users[$i]->id,$from,$to)
             ));
             $row++;
             }

             $sheet->row($row, array(
             '','Total',$completed,$cancelled,$orders,$total
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

        $users = User::all();
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
    
    public function usersummaryreport($id){
        return view('admin.usersummaryreport',compact('id'));
    }

    public function getusersummaryreport(Request $request, $id){
        if($request->type == 'excel'){

        $user = User::find($id);

        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        Excel::create($user->name.'_Summary_Report_'.$f.'_'.$t, function($excel) use ($from, $to, $f, $t, $user) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Summary Report', function($sheet) use ($from, $to, $f, $t, $user){
            $users = User::where('role','waiter')->get();

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
              $user->name.' SUMMARY REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'WAITER','COMPLETED ORDERS', 'CANCELLED ORDERS', 'TOTAL ORDERS', 'TOTAL AMOUNT HELD'
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

            $orders = $orders + User::getRangeOrders($user->id,$from,$to);
            $completed = $completed + User::getRangeCompleted($user->id,$from,$to);
            $cancelled = $cancelled + User::getRangeCancelled($user->id,$from,$to);
            $total = $total + User::getRangeAmount($user->id,$from,$to);
                
            
             $sheet->row($row, array(
             $user->name,User::getRangeCompleted($user->id,$from,$to),User::getRangeCancelled($user->id,$from,$to),User::getRangeOrders($user->id,$from,$to),User::getRangeAmount($user->id,$from,$to)
             ));
             

             $sheet->row(7, array(
             'Total',$completed,$cancelled,$orders,$total
             ));
            $sheet->row(7, function ($r) {

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

        $user = User::find($id);
        $organization = Setting::find(1);
        $view = \View::make('admin.viewusersummaryreport',compact('user','organization','f','t','from','to'));
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
