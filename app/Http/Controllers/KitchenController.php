<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orderitem;
use App\Order;
use Illuminate\Support\Facades\Auth;

class KitchenController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function neworders(){
      $orders = Order::all();
      foreach ($orders as $order) {
      $order->is_received = 1;
      $order->receiver_id = Auth::user()->id;
      $order->received_time = date('Y-m-d H:i:s');
      $order->update();
      }

      return redirect('/');
    }

    public function updatebeep(){
      $orders = Order::all();
      foreach ($orders as $order) {
      $order->is_beep = 1;
      $order->update();
      }
    }

    public function getneworders(){
      $data = array();
      $orders = Order::whereDate('created_at',date('Y-m-d'))->where('is_complete',0)->orderBy('id','DESC')->get();
      $neworders = Order::whereDate('created_at',date('Y-m-d'))->where('is_received',0)->get();
      $nobeep = Order::whereDate('created_at',date('Y-m-d'))->where('is_received',0)->where('is_beep',1)->get();
      $beep = Order::whereDate('created_at',date('Y-m-d'))->where('is_received',0)->where('is_beep',0)->get();
      $data['neworders'] = count($neworders);
      $data['pendingorders'] = count($orders);
      $data['checkbeep'] = count($beep);
      return json_encode($data);
    }

    public function orderitems($id){
      $orders = Order::whereDate('created_at',date('Y-m-d'))->where('is_complete',0)->orderBy('id','DESC')->get();
      $neworders = Order::whereDate('created_at',date('Y-m-d'))->where('is_received',0)->get();
      $orderitems = Orderitem::where('order_id',$id)->get();
      return view('kitchen.show',compact('orderitems','id','orders','neworders'));
    }

    public function completeorder($id){
      $order = Order::find($id);
      $order->is_complete = 1;
      $order->kitchen_id = Auth::user()->id;
      $order->update();

      return redirect()->back()->withFlashMessage('Order Successfully Completed!');
    }

    public function uncompleteorder($id){
      $order = Order::find($id);
      $order->is_complete = 0;
      $order->update();

      return redirect()->back()->withFlashMessage('Order Successfully Reversed!');
    }

    public function returnorder($id){
      $order = Order::find($id);
      $order->is_cancelled = 0;
      $order->is_paid = 0;
      $order->update();

      return redirect()->back()->withFlashMessage('Order Successfully Returned!');
    }

    public function completekitchenorder(){
      $orders = Order::whereDate('created_at',date('Y-m-d'))->where('is_complete',0)->orderBy('id','DESC')->get();
      $neworders = Order::whereDate('created_at',date('Y-m-d'))->where('is_received',0)->get();
      $completeorders = Order::where('is_complete',1)->where('kitchen_id',Auth::user()->id)->orderBy('id','DESC')->get();
      return view('kitchen.completedorders',compact('completeorders','orders','neworders'));
    }

    public function pendingkitchenorder(){
      $orders = Order::whereDate('created_at',date('Y-m-d'))->where('is_complete',0)->orderBy('id','DESC')->get();
      $neworders = Order::whereDate('created_at',date('Y-m-d'))->where('is_received',0)->get();
      $pendingorders = Order::where('is_complete',0)->where('is_cancelled',0)->orderBy('id','DESC')->get();
      return view('kitchen.pendingorders',compact('pendingorders','orders','neworders'));
    }

    public function cancelledkitchenorder(){
      $orders = Order::whereDate('created_at',date('Y-m-d'))->where('is_complete',0)->orderBy('id','DESC')->get();
      $neworders = Order::whereDate('created_at',date('Y-m-d'))->where('is_received',0)->get();
      $cancelledorders = Order::where('is_cancelled',1)->where('cancel_id',Auth::user()->id)->orderBy('id','DESC')->get();
      return view('kitchen.cancelledorders',compact('cancelledorders','orders','neworders'));
    }

    public function cancelorder($id){
      $order = Order::find($id);
      $order->is_cancelled = 1;
      $order->is_paid = 0;
      $order->cancel_id = Auth::user()->id;
      $order->update();

      return redirect()->back()->withFlashMessage('Order Successfully Cancelled!');
    }

    public function cancelorderitem($id){
      $order = Orderitem::find($id);
      $order->is_cancelled = 1;
      $order->cancel_id = Auth::user()->id;
      $order->update();

      return redirect()->back()->withFlashMessage('Order Successfully Cancelled!');
    }

    public function report(){
        return view('kitchen.report');
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
              '#', 'ORDER NO.', 'DATE', 'AMOUNT', 'STATUS', 'PAID', 'PLACED BY', 'RECEIVED BY', 'COMPLETED BY', 'PAID THROUGH', 'CANCELLED BY'
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
             ($i+1),$orders[$i]->order_no,date('d-M-Y',strtotime($orders[$i]->created_at)),Orderitem::getAmount($orders[$i]->id),$status,$paid,User::getUser($orders[$i]->waiter_id),User::getUser($orders[$i]->receiver_id),User::getUser($orders[$i]->kitchen_id),User::getUser($orders[$i]->cashier_id),User::getUser($orders[$i]->cancel_id)
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
        $time1 = strtotime(date('Y-m-d',strtotime($request->to)).' 00:00:00');

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
}
