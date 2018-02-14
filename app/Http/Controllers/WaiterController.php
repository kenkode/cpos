<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Orderitem;
use App\Order;
use App\Setting;
use PDF;
use PHPExcel;
use PHPExcel_Cell;
use Maatwebsite\Excel\Facades\Excel as Excel;
use Illuminate\Support\Facades\Auth;

class WaiterController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
      $orders = Order::whereDate('created_at',date('Y-m-d'))->where('waiter_id',Auth::user()->id)->orderBy('id','DESC')->get();
    	return view('waiter.index',compact('orders'));
    }

    public function orders(){
      $orders = Order::where('waiter_id',Auth::user()->id)->orderBy('id','DESC')->get();
      return view('waiter.orders',compact('orders'));
    }

    public function summary(){
      
            $orders = Order::where('waiter_id',Auth::user()->id)->count();
            $cancelled = Order::where('waiter_id',Auth::user()->id)->where('is_cancelled',1)->count();
            $completed = Order::where('waiter_id',Auth::user()->id)->where('is_cancelled',0)->count();
            $amount = Orderitem::where('waiter_id',Auth::user()->id)->where('is_cancelled',0)->sum('amount');
            return view('waiter.summary',compact('orders','cancelled','amount','completed'));
    }

    public function orderitems($id){
      $orderitems = Orderitem::where('waiter_id',Auth::user()->id)->where('order_id',$id)->get();
      return view('waiter.show',compact('orderitems','id'));
    }

    public function send(Request $request){
        $jcart = array();
        parse_str($request->jcart,$jcart);
        $organization = Setting::find(1);
        $o = Order::orderBy('id','DESC')->first();

        $ret = '';
        $bid = 0;
        if(count($o)>0){
        $bid = $o->id+1;
        }else{
        $bid = 0;
        }
        foreach (explode(' ', $organization->name) as $word){
        if($word == null){
        $ret .= strtoupper($str[0]); 
        }else{
        $ret .= strtoupper($word[0]);
        }
        }
        $orderno = '#' . $ret . str_pad(($bid), 6, '0', STR_PAD_LEFT);

        $order = new Order;
        $order->order_no = $orderno;
        $order->amount = str_replace(',', '', $jcart['jcartSubtotal']);
        $order->is_paid = 1;
        $order->is_cancelled = 0;
        $order->waiter_id = Auth::user()->id;
        $order->payment_method = $jcart['payment_method'];
        $order->transaction_number = $jcart['trans_no'];
        $order->amount_paid = str_replace(',','',$jcart['amount']);
        $order->save();

        for($i=0;$i<count($jcart['jcartItemName']); $i++){
        $orderitem = new Orderitem;
        $orderitem->order_id = $order->id;
        $orderitem->food_id = preg_replace("/[^0-9]/",'',$jcart['jcartItemId'][$i]);
        $orderitem->quantity = $jcart['jcartItemQty'][$i];
        $orderitem->size = $jcart['jcartItemSize'][$i];
        $orderitem->amount = $jcart['jcartItemPrice'][$i];
        $orderitem->is_cancelled = 0;
        $orderitem->waiter_id = Auth::user()->id;
        $orderitem->save();
        }

        return $order->id;
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

    public function receipt($id){
        
        $orderitems = Orderitem::where('order_id', $id)->get();
        $order = Order::find($id);
        $organization = Setting::find(1);
        $view = \View::make('admin.receipt',compact('orderitems','order','organization','f','t'));
        $html = $view->render();

        PDF::setFooterCallback(function($pdf) use ($organization){

        // Position at 15 mm from bottom
        $pdf->SetY(-15);
        // Set font
        $pdf->SetFont('helvetica', 'I', 6);
        // Page number
        $pdf->Cell(0, 10, $organization->receipt_footer, 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });

        //$pdf = new TCPDF();
        PDF::SetTitle('Receipt');
        PDF::AddPage('P','A7');
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output($order->order_no.'_receipt.pdf');
    }

    public function individualreport($id){
        return view('waiter.individualreport',compact('id'));
    }

    public function report(){
        return view('waiter.report');
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
              $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->where('waiter_id',Auth::user()->id)->get();
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
              'ORDERS REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'ORDER NO.', 'DATE', 'AMOUNT', 'STATUS', 'PAID'
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
            $total = $total + Orderitem::getAmount($orders[$i]->id);

            if($orders[$i]->is_cancelled == 1 ){
            $status = 'Cancelled';
            }else{
            $status = 'Complete';
            }

            if($orders[$i]->is_paid == 1){
            $paid='Paid';
            }else{
            $paid='Reversed';
            }
            
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),Orderitem::getAmount($orders[$i]->id),$status,$paid
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

        $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->where('waiter_id',Auth::user()->id)->get();
        $organization = Setting::find(1);
        $view = \View::make('waiter.viewreport',compact('orders','organization','f','t'));
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

    public function summaryreport(){
        return view('waiter.summaryreport');
    }

    public function getsummaryreport(Request $request){
        if($request->type == 'excel'){

        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        Excel::create('My_Summary_Report_'.$f.'_'.$t, function($excel) use ($from, $to, $f, $t) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('My Summary Report', function($sheet) use ($from, $to, $f, $t){
            $orders = Order::where('waiter_id',Auth::user()->id)->whereBetween('created_at', array($from, $to))->count();
            $cancelled = Order::where('waiter_id',Auth::user()->id)->whereBetween('created_at', array($from, $to))->where('is_cancelled',1)->count();
            $completed = Order::where('waiter_id',Auth::user()->id)->whereBetween('created_at', array($from, $to))->where('is_cancelled',0)->count();
            $amount = Orderitem::where('waiter_id',Auth::user()->id)->whereBetween('created_at', array($from, $to))->where('is_cancelled',0)->sum('amount');
              $organization = Setting::find(1);

               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:C3');
              $sheet->row(3, array(
              'SUMMARY REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'COMPLETED ORDERS', 'CANCELLED ORDERS', 'TOTAL ORDERS', 'TOTAL AMOUNT HELD'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            

    
             $sheet->row($row, array(
             $completed,$cancelled,$orders,$amount
             ));
       
             
    });

  })->download('xls');

        }else{
        $time = strtotime(date('Y-m-d',strtotime($request->from)).' 00:00:00');
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = $request->from;
        $t = $request->to;

        $orders = Order::where('waiter_id',Auth::user()->id)->whereBetween('created_at', array($from, $to))->count();
        $cancelled = Order::where('waiter_id',Auth::user()->id)->whereBetween('created_at', array($from, $to))->where('is_cancelled',1)->count();
        $completed = Order::where('waiter_id',Auth::user()->id)->whereBetween('created_at', array($from, $to))->where('is_cancelled',0)->count();
        $amount = Orderitem::where('waiter_id',Auth::user()->id)->whereBetween('created_at', array($from, $to))->where('is_cancelled',0)->sum('amount');
        $organization = Setting::find(1);
        $view = \View::make('waiter.viewsummaryreport',compact('orders','completed','cancelled','amount','organization','f','t'));
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
        PDF::SetTitle('My Summary');
        PDF::AddPage('L');
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('my_summary_'.$f.'_'.$t.'.pdf');
        }
    }

    public function todayreport(){
        return view('waiter.todayreport');
    }

    public function gettodayreport(Request $request){
        if($request->type == 'excel'){

        $time = strtotime(date('Y-m-d').' 00:00:00');
        $time1 = strtotime(date('Y-m-d').' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = date('Y-m-d');
        $t = date('Y-m-d');

        Excel::create('Orders_Report_'.$f.'_'.$t, function($excel) use ($from, $to, $f, $t) {

        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
        require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


       $objPHPExcel = new PHPExcel(); 
       // Set the active Excel worksheet to sheet 0
       $objPHPExcel->setActiveSheetIndex(0); 
    

        $excel->sheet('Orders Report', function($sheet) use ($from, $to, $f, $t){
              $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->where('waiter_id',Auth::user()->id)->get();
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
              'ORDERS REPORT BETWEEN '.$f.' AND '.$t
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'ORDER NO.', 'DATE', 'AMOUNT', 'STATUS', 'PAID'
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
            $total = $total + Orderitem::getAmount($orders[$i]->id);

            if($orders[$i]->is_cancelled == 1 ){
            $status = 'Cancelled';
            }else{
            $status = 'Complete';
            }

            if($orders[$i]->is_paid == 1){
            $paid='Paid';
            }else{
            $paid='Reversed';
            }
            
             $sheet->row($row, array(
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),Orderitem::getAmount($orders[$i]->id),$status,$paid
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
        $time = strtotime(date('Y-m-d').' 00:00:00');
        $time1 = strtotime(date('Y-m-d').' 23:59:59');

        $from = date('Y-m-d H:i:s',$time);
        $to = date('Y-m-d H:i:s',$time1);

        $f = date('Y-m-d');
        $t = date('Y-m-d');

        $orders = Order::orderBy('id','DESC')->whereBetween('created_at', array($from, $to))->where('waiter_id',Auth::user()->id)->get();
        $organization = Setting::find(1);
        $view = \View::make('waiter.viewtodayreport',compact('orders','organization','f','t'));
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

}
