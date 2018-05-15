<?php

namespace App\Http\Controllers;

use App\Chat;
//use Barryvdh\DomPDF\PDF;
use PDF;
use Illuminate\Http\Request;

class DownloadChatAsPDFController extends Controller
{
    public function printChat (Request $request, Chat $chat) {

//        return view('pdf.chat', compact('chat'));
        $pdf = PDF::loadView('pdf.chat', compact('chat'));
        return $pdf->stream("{$chat->name}.pdf");
    }
    public function download(Request $request, Chat $chat)
    {
        $pdf = PDF::loadView('pdf.chat', compact('chat'));

        return $pdf->download("{$chat->name}.pdf");
//        return view('pdf.chat', compact('chat'));

    }
}
