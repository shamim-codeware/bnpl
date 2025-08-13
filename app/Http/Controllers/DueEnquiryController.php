<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DueEnquiryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        dd("invoke");
    }
}
