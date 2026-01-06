<?php

namespace App\Http\Controllers;

use App\Models\Trainer;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::orderBy('created_at', 'desc')->get();

        return view('trainer', [
            'trainers' => $trainers,
            'title'    => 'Personal Trainer | Thunder Fitness',
        ]);
    }
}
