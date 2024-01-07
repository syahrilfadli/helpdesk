<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserCatgory;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $month = $request->input('filterMonth', date('n'));
        $year = $request->input('filterYear', date('Y'));

        $provinces = Province::all();

        // Mendapatkan list city berdasarkan province yang dipilih (jika ada)
        $selectedProvinceId = $request->input('filterProvince');
        $cities = $selectedProvinceId
            ? City::where('province_id', $selectedProvinceId)->get()
            : collect(); // Jika province belum dipilih, berikan collection kosong


        $categories   = Category::count();
        $open_ticket  = Ticket::whereIn('status', ['On Hold','In Progress'])->count();
        $close_ticket = Ticket::where('status', '=', 'Closed')->count();
        // $agents       = \DB::table('model_has_roles')->where('model_type', '=', 'App\Models\User')->where('role_id', '=', '2')->count();
        $agents       = User::where('parent',\Auth::user()->createId())->count();

        $categoriesChart = Ticket::select(
            [
                'categories.name',
                'categories.color',
                \DB::raw('count(*) as total'),
            ]
        )->join('categories', 'categories.id', '=', 'tickets.category')->groupBy('categories.id')->get();

        $chartData = [];
        $chartData['color'] = [];
        $chartData['name']  = [];
        $chartData['value'] = [];

        if(count($categoriesChart) > 0)
        {
            foreach($categoriesChart as $category)
            {
                $chartData['name'][]  = $category->name;
                $chartData['value'][] = $category->total;
                $chartData['color'][] = $category->color;
            }
        }

        $monthData = [];

        $barChart = Ticket::select([
            \DB::raw('MONTH(created_at) as month'),
            \DB::raw('YEAR(created_at) as year'),
            \DB::raw('count(*) as total'),
        ])->whereMonth('created_at', $month)->whereYear('created_at', $year)->groupBy([
            \DB::raw('MONTH(created_at)'),
            \DB::raw('YEAR(created_at)'),
        ])->get();


        $start = \Carbon\Carbon::now()->startOfYear();

        for ($i = 0; $i <= 11; $i++) {

            $monthData[$start->format('M')] = 0;
            foreach($barChart as $chart)
            {
                if(intval($chart->month) == intval($start->format('m')))
                {
                    $monthData[$start->format('M')] = $chart->total;
                }
            }
            $start->addMonth();
        }

        $categoriesChartTable = Category::select([
            'categories.name',
            'categories.color',
            \DB::raw('count(tickets.id) as total'),
            \DB::raw('sum(case when tickets.status = "On Hold" then 1 else 0 end) as on_hold_count'),
            \DB::raw('sum(case when tickets.status = "In Progress" then 1 else 0 end) as in_progress_count'),
            \DB::raw('sum(case when tickets.status = "Closed" then 1 else 0 end) as closed_count'),
        ])->leftJoin('tickets', 'categories.id', '=', 'tickets.category')->groupBy('categories.id')->get();


          // Mengganti kueri untuk mendapatkan daftar agen tanpa filter peran
          $agentsWithMostTickets = \DB::table('users')
            ->select('users.id as id', 'users.name as agent_name', \DB::raw('count(user_categories.id) as ticket_count'))
            ->join('user_categories', 'user_categories.user_id', '=', 'users.id')
            ->leftJoin('tickets', function ($join) {
                $join->on('user_categories.category_id', '=', 'tickets.category');
            })
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('ticket_count')
            ->limit(10) // Ambil 10 teratas
            ->get();


        $agentData = \DB::table('users')
            ->select(
                'users.name as agent_name',
                \DB::raw('count(tickets.id) as ticket_count'),
                \DB::raw('SEC_TO_TIME(SUM(CASE WHEN conversions.sender = users.id THEN TIMESTAMPDIFF(SECOND, tickets.created_at, conversions.created_at) ELSE 0 END)) as total_response_time')
            )
            ->leftJoin('user_categories', 'user_categories.user_id', '=', 'users.id')
            ->leftJoin('tickets', function ($join) {
                $join->on('user_categories.category_id', '=', 'tickets.category');
            })
            ->leftJoin('conversions', 'conversions.ticket_id', '=', 'tickets.id')
            ->whereIn('users.id', $agentsWithMostTickets->pluck('id'))
            ->groupBy('users.id', 'users.name')
            ->get();
            \Log::info($agentsWithMostTickets);
        // ,  'agentData', 'agentsList'

        $userProvinces = User::whereIn('type',['Agent','User'])->whereNotNull('province_id')
        ->pluck('province_id');

        // Ambil tiket berdasarkan ID provinsi dan sertakan informasi pengguna terkait
        // $tickets = Ticket::whereIn('created_by', function ($query) use ($userProvinces) {
        //     $query->select('id')
        //         ->from('users')
        //         ->whereIn('type',['Agent','User'])
        //         ->whereIn('province_id', $userProvinces);
        // })->with('creator')->get();

        $tickets = Ticket::select(
            'users.province_id',
            'users.province_id as province_id',
            'province.name as province_name',
            \DB::raw('COUNT(*) as ticket_count')
        )
        ->join('users', 'tickets.created_by', '=', 'users.id')
        ->join('province', 'users.province_id', '=', 'province.id')
        ->whereIn('users.type', ['Agent', 'User'])
        ->whereIn('users.province_id', $userProvinces)
        ->groupBy('users.province_id', 'province.name')
        ->get();

        // $ticketCounts = Ticket::select('users.province_id', DB::raw('count(*) as ticket_count'))
        // ->join('users', 'tickets.created_by', '=', 'users.id')
        // ->whereIn('users.type', ['Agent', 'User'])
        // ->whereIn('users.province_id', $userProvinces)
        // ->groupBy('users.province_id')
        // ->get();

        return view('admin.dashboard.index', compact('categories', 'open_ticket', 'close_ticket', 'agents', 'chartData', 'monthData', 'categoriesChartTable', 'agentsWithMostTickets', 'agentData', 'request',  'provinces','cities', 'tickets'));
    }

    public function getCitiesByProvince(Request $request)
    {
        $provinceId = $request->input('province_id');

        // Ambil daftar kota berdasarkan province_id
        $cities = City::where('province_id', $provinceId)->get();

        return response()->json($cities);
    }

}
