<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Tenant;
use App\Helpers\DataStatic;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
	public function __construct(DataStatic  $static) {
        $this->prefix = 'report.order';
        $this->routePath = 'report.order';
        $this->model = new Order;
        $this->static = $static;
    }

    public function index()
    {
    	return view($this->prefix.'.index');
    }

    public function view(Request $request)
    {
        $user = $request->user();

    	$html = '<div class="container-table">
                        <table class="table table-bordered fixed-table">
                            <tbody>
                                <tr>
                                    <th rowspan="3" style="text-align: center; width: 80px;">No</th>
                                    <th rowspan="3" style="text-align: left; width: 300px;">Tenant</th>
                                    <th rowspan="3" style="text-align: left; width: 300px;">Product Name</th>
                                    <th rowspan="3" style="text-align: left; width: 100px;">QTY</th>
                                    <th rowspan="3" style="text-align: left; width: 300px;">Price</th>
                                    <th rowspan="3" style="text-align: left; width: 300px;">Sub Total</th>';
        $html .= '</tr></tbody></table></div>';
        $html .= '<div class="container-table-content">
                    <table class="table table-bordered fixed-table">
                        <tbody>';

        $orders = $this->getOrders($request->only(['start', 'end', 'tenant']));

        $no = 1;
        foreach ($orders as $order) {
        	$html .= '<tr>
                    <td style="text-align: center; width: 80px;">'.$no.'</td>
                    <td style="text-align: left; width: 300px;">'.$order->name.'</td>
                    <td style="text-align: left; width: 300px;">'.$order->product_name.'</td>
                    <td style="text-align: left; width: 100px;">'.$order->qty.'</td>
                    <td style="text-align: left; width: 300px;">'.$order->price.'</td>
                    <td style="text-align: left; width: 300px;">'.$order->price * $order->qty.'</td>';
            $html .= '</tr>';

            $no++;
        }

        $html .= '</tbody></table></div>';

        $html .= '<script type="text/javascript">
                $(".container-table-content").on("scroll", function() {
                    $(".container-table").scrollLeft($(this).scrollLeft());
                });
                $(".container-table").on("scroll", function() {
                    $(".container-table-content").scrollLeft($(this).scrollLeft());
                });
            </script>';

    	return $html;
    }

    public function export(Request $request) 
    {
        ini_set('memory_limit', '512M');

        $user = $request->user();
        $startPeriod = $request->input('start');
        $endPeriod = $request->input('end');

        $filename = 'report_order_tlm_'.$startPeriod.'_'.$endPeriod;

        $spreadsheet = new Spreadsheet();
        $header = ['No', 'Tenant', 'Product Name', 'QTY', 'Price', 'Sub Total'];

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Report TLM');
        $sheet->fromArray($header,NULL,'A1');

        $orders = $this->getOrders($request->only(['start', 'end', 'tenant']));

        $no = 1;
        $row = 2;
        $departments = [];
        $depName = '';
        foreach ($orders as $order) {
            $content = [
                $no,
                $order->name,
                $order->product_name,
                $order->qty,
                $order->price,
                $order->price * $order->qty
            ];

            $sheet->fromArray($content,NULL,'A'.$row);

            $no++;
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function getTenant() {
        $result = Tenant::select('id', 'name')->get();

        return $this->success('success', $result);
    }

    private function getOrders($value)
    {
        $query = $this->model->leftJoin('order_details', 'order_details.order_id', 'orders.id')
            ->leftJoin('tenants', 'tenants.id', 'orders.tenant_id')
            ->whereDate('orders.created_at',  '>=', $value['start'])
            ->whereDate('orders.created_at',  '<=', $value['end']);

            if($value['tenant']) {
                $query->whereIn('tenants.id', [$value['tenant']]);
            }

        return $query->orderBy('tenants.name')->get();
    }
}
