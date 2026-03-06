<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CurriculumController extends Controller
{
    public function showCurriculumList()
    {
        $now = Carbon::now();

        $curriculums = DB::table('curriculums')
            ->leftJoin('delivery_times', 'delivery_times.curriculums_id', '=', 'curriculums.id')
            ->where(function ($query) use ($now) {
                $query->where('curriculums.alway_delivery_flg', 1)
                    ->orWhere(function ($q) use ($now) {
                        $q->where('delivery_times.delivery_from', '<=', $now)
                          ->where('delivery_times.delivery_to', '>=', $now);
                    });
            })
            ->select(
                'curriculums.id',
                'curriculums.title',
                'curriculums.thumbnail',
                'curriculums.alway_delivery_flg',
                'delivery_times.delivery_from',
                'delivery_times.delivery_to'
            )
            ->orderBy('curriculums.id')
            ->get();

        return view('user.curriculum_list', compact('curriculums'));
    }
}