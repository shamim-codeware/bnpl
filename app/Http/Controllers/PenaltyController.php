<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Penalty;
use App\Models\Installment;
use Illuminate\Http\Request;
use App\Exports\PenaltyExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\In;
use Maatwebsite\Excel\Facades\Excel;

class PenaltyController extends Controller
{

    // public function store(Request $request, $id){
    //    $data = $this->validate($request, [
    //         'penalty' => 'required',
    //     ]);
    //     $message = isset($data['id'] ) ? "Penelty Updated Successfully" : "Penalty Created Successfully";
    //     if($data['id']){
    //         $penalty =  Penalty::find($data['id']);
    //         $penalty->update($data);
    //     }else{
    //         $penalty = new Penalty();
    //         $penalty->create($data);
    //     }

    //     return redirect()->back()->with('success',$message);
    // }



    public function index()
    {
        $title = "Penalty";
        $description ="Some Description Here";
        return view('pages.settings.penalty.index', compact('title','description'));
    }
    public function store(Request $request, $id = null)
    {
        $data = $request->validate([
            'penalty' => 'required',
        ]);
        $message = $id ? "Penalty Updated Successfully" : "Penalty Created Successfully";
        Penalty::updateOrCreate(['id' => $id], $data);
        return redirect()->back()->with('success', $message);
    }

    public function PenaltyList()
    {
        $title = "Penalty List";
        $description ="Some Description Here";
        $penalties = [];
        return view('pages.settings.penalty.list', compact('title','description','penalties'));
    }

    public function AllPenaltyAction(Request $request)
    {
        $query = Penalty::query()->with('installment');
        $order_no = $request->order_no ? $request->order_no : null;
        if ($order_no) {
            $query->whereHas('installment', function ($q) use ($order_no) {
                $q->where('order_no', $order_no);
            });
        }
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : date('Y-m-01') . ' 00:00:00';
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : date('Y-m-t') . ' 23:59:59';
        $query->whereBetween('created_at', [$from_date, $to_date])
            ->latest();

        if ($request->notice_no) {
            $query->where('notice_no', $request->notice_no);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }



        $penalties = $query->paginate(20);
        return view('pages.settings.penalty.action-list', compact("penalties"));
    }

    public function export(Request $request)
    {
        $query = Penalty::query()->with('installment');
        $order_no = $request->order_no ? $request->order_no : null;
        if ($order_no) {
            $query->whereHas('installment', function ($q) use ($order_no) {
                $q->where('order_no', $order_no);
            });
        }
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : date('Y-m-01') . ' 00:00:00';
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : date('Y-m-t') . ' 23:59:59';
        $query->whereBetween('created_at', [$from_date, $to_date]);


        if ($request->notice_no) {
            $query->where('notice_no', $request->notice_no);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

            $penalties = $query->orderBy('id','DESC')->get();
        return Excel::download(new PenaltyExport($penalties), 'penalty-report.xlsx');
    }

    public function status($id, $status)
    {
        $penalty = Penalty::findOrFail($id);

        if ($status != "pending" && $penalty->action == 0) {
            $penalty->status = $status;
            $penalty->status_date = now();
            $penalty->action = 1;
            $penalty->save();
            return response()->json(['status' => "success", 'message' => 'Success! Status Changed.']);
        }

        return response()->json(['status' => "error", 'message' => 'Error! Status Not Changed.']);
    }

    /* public function download($id)
    {
        $penalty = Penalty::findOrFail($id);
        $file_name = $penalty->notice_no."-".$penalty->type;
        $pdf = Pdf::loadView("PDF.penaltie_notice.{$file_name}", [
            'penalty' => $penalty
        ]);
        return $pdf->download("{$penalty->order_no}-{$file_name}".".pdf");
    } */



    // public function download($id)
    // {
    //     $penalty = Penalty::findOrFail($id);
    //     $file_name = $penalty->notice_no."-".$penalty->type;

    //     $mpdf = new Mpdf([
    //         'mode' => 'utf-8',
    //         'format' => 'A4',
    //         'fontDir' => [public_path('assets/fonts/solaimanlipi')],
    //         'fontdata' => [
    //             'solaimanlipi' => [
    //                 'R' => 'SolaimanLipiNormal.ttf',
    //             ]
    //         ],
    //         'default_font' => 'solaimanlipi'
    //     ]);

    //     $html = view("PDF.penalty_notice.{$file_name}", [
    //         'penalty' => $penalty
    //     ])->render();

    //     $mpdf->WriteHTML($html);

    //     return $mpdf->Output("{$penalty->order_no}-{$file_name}.pdf", 'D');
    // }

    public function download($id)
    {
        $penalty = Penalty::with(['installment', 'installment.hire_purchase', 'installment.hire_purchase.guaranter_info', 'installment.hire_purchase.purchase_products'])->findOrFail($id);
        $file_name = $penalty->notice_no . "-" . $penalty->type;


        $mpdf = new Mpdf([
            'default_font_size' => 14,
            'default_font' => 'solianmolipinormal',
            'mode' => 'utf-8',
            'format' => 'A4',
            'autoPageBreak' => true, // Enable AutoPageBreak
            // 'debug' => true, // Enable error reporting
            'enable_redirects' => false, // Disable HTTP redirects
        ]);

        $html = view("PDF.penalty_notice.{$file_name}", [
            'penalty' => $penalty
        ])->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output("{$penalty->order_no}-{$file_name}.pdf", 'D');
    }
}
