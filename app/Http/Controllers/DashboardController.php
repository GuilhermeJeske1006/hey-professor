<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        return view('dashboard', [
            'questions' => Question::withSum('votes', 'like')
                ->withSum('votes', 'unlike')
                ->orderByRaw('
                    case when votes_sum_like is null then 0 else votes_sum_like end desc,
                    case when votes_sum_unlike is null then 0 else votes_sum_unlike end
                ')
                ->paginate(10),
        ]);
    }
}
