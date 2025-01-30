<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ButtonController extends Controller
{
    public function showButtons()
    {
        return view('buttons');
    }

    public function page1()
    {
        return view('page1');
    }

    public function page2()
    {
        return view('page2');
    }

    public function page3()
    {
        return view('page3');
    }

    public function page4()
    {
        return view('page4');
    }

    public function page5()
    {
        return view('page5');
    }

    public function page6()
    {
        return view('page6');
    }
}