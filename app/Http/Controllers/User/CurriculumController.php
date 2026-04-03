<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function showCurriculumList(Request $request)
    {
        $data = $this->getCurriculumListData($request);

        if ($request->ajax()) {
            $curriculums = $data['curriculums']->map(function ($curriculum) {
                return [
                    'id' => $curriculum->id,
                    'title' => $curriculum->title,
                    'thumbnail' => !empty($curriculum->thumbnail) ? asset($curriculum->thumbnail) : null,
                    'is_always' => (int) $curriculum->alway_delivery_flg === 1,
                    'delivery_times' => $curriculum->deliveryTimes
                        ->filter(function ($time) {
                            return !empty($time->delivery_from) && !empty($time->delivery_to);
                        })
                        ->map(function ($time) {
                            return [
                                'delivery_from' => Carbon::parse($time->delivery_from)->format('n月j日 H:i'),
                                'delivery_to' => Carbon::parse($time->delivery_to)->format('H:i'),
                            ];
                        })
                        ->values(),
                ];
            })->values();

            return response()->json([
                'curriculums' => $curriculums,
                'selectedGradeId' => $data['selectedGradeId'],
                'selectedGradeLabel' => $data['selectedGradeLabel'],
                'year' => $data['year'],
                'month' => $data['month'],
                'prevYear' => $data['prevMonth']->year,
                'prevMonth' => $data['prevMonth']->month,
                'nextYear' => $data['nextMonth']->year,
                'nextMonth' => $data['nextMonth']->month,
            ]);
        }

        return view('user.curriculum_list', $data);
    }

    private function getCurriculumListData(Request $request): array
    {
        $selectedGradeId = $request->input('grade_id');
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);

        if ($month < 1 || $month > 12) {
            $month = now()->month;
        }

        if ($year < 2000 || $year > 2100) {
            $year = now()->year;
        }

        $currentMonth = Carbon::create($year, $month, 1);
        $prevMonth = $currentMonth->copy()->subMonth();
        $nextMonth = $currentMonth->copy()->addMonth();

        $monthStart = $currentMonth->copy()->startOfMonth()->format('Y-m-d H:i:s');
        $monthEnd = $currentMonth->copy()->endOfMonth()->format('Y-m-d H:i:s');

        $query = Curriculum::with([
            'deliveryTimes' => function ($query) use ($monthStart, $monthEnd) {
                $query->whereBetween('delivery_from', [$monthStart, $monthEnd])
                    ->orderBy('delivery_from', 'asc');
            }
        ]);

        if (!empty($selectedGradeId)) {
            $query->where('grade_id', $selectedGradeId);
        }

        $query->where(function ($q) use ($monthStart, $monthEnd) {
            $q->where('alway_delivery_flg', 1)
              ->orWhereHas('deliveryTimes', function ($query) use ($monthStart, $monthEnd) {
                  $query->whereBetween('delivery_from', [$monthStart, $monthEnd]);
              });
        });

        $curriculums = $query->get();

        return [
            'curriculums' => $curriculums,
            'selectedGradeId' => $selectedGradeId,
            'selectedGradeLabel' => $this->getGradeLabel($selectedGradeId),
            'year' => $year,
            'month' => $month,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
        ];
    }

    private function getGradeLabel($gradeId): string
    {
        $gradeMap = [
            1 => '小学校1年生',
            2 => '小学校2年生',
            3 => '小学校3年生',
            4 => '小学校4年生',
            5 => '小学校5年生',
            6 => '小学校6年生',
            7 => '中学校1年生',
            8 => '中学校2年生',
            9 => '中学校3年生',
            10 => '高校1年生',
            11 => '高校2年生',
            12 => '高校3年生',
        ];

        return $gradeMap[(int) $gradeId] ?? '学年未選択';
    }
}