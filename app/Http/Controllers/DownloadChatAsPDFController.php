<?php

namespace App\Http\Controllers;

use App\Chat;
use PDF;
use Illuminate\Http\Request;

class DownloadChatAsPDFController extends Controller
{
    public function index(Request $request, Chat $chat)
    {

        $pdf = PDF::loadView('pdf.chat', compact('chat'));

        return $pdf->download('invoice.pdf');
    }
}
