<?php

namespace App\Http\Controllers;

use App\MonthlyStatistic;
use Cache;
use Illuminate\Http\Request;

class MonthlyStatisticController extends Controller
{
    /**
     *
     */
    public function show()
    {
        $messages = Cache::rememberForever('messages', function() {
            return MonthlyStatistic::where('year', 2018)->pluck('chat_messages');
        });
        $totalUsers = Cache::rememberForever('total_users', function() {
            return MonthlyStatistic::where('year', 2018)->pluck('total_users');
        });
        $users = Cache::rememberForever('new_users', function() {
            return MonthlyStatistic::where('year', 2018)->pluck('new_users');
        });

        return view('statistics.show', compact('messages','totalUsers','users'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MonthlyStatistic::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MonthlyStatistic::create($request->only('year','month','new_users','total_users','chat_messages'));
    }
}