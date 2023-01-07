<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::whereHas('matter', function ($q) {
            $q->where('user_id', Auth::id());
        })
        ->with('matter')
        ->orderBy('appointment_date', 'desc')
        ->get();
        return response()->json(['status' => true, 'appointments' => $appointments], 200);
    }

    public function get_calendar($year, $month) {
        $firstOfMonth = Carbon::create($year, $month)->firstOfMonth();
        $firstOfCalendar = $firstOfMonth->subDays((int) $firstOfMonth->format('w'));
        $lastOfMonth = Carbon::create($year, $month)->lastOfMonth();
        $lastOfCalendar = $lastOfMonth->addDays(6 - (int) $lastOfMonth->format('w'));
        $countOfRow = (int) ceil($lastOfCalendar->diffInDays($firstOfCalendar) / 7);

        $calendar = [];
        for ($week = 0; $week < $countOfRow; $week++) {
            $weekRow = [];
            for ($day = 0; $day < 7; $day++) {
                $appointments = Appointment::whereHas('matter', function ($q) {
                    $q->where('user_id', Auth::id());
                })
                ->with('matter')
                ->whereYear('appointment_date', $year)
                ->whereMonth('appointment_date', $month)
                ->whereDay('appointment_date', $firstOfCalendar->format('j'))
                ->get();
                array_push($weekRow, [
                    'date' => $firstOfCalendar->format('j'),
                    'dayOfWeek' => $firstOfCalendar->format('w'),
                    'appointments' => $appointments,
                ]);
                $firstOfCalendar->addDays(1);
            }
            array_push($calendar, $weekRow);
        }

        return response()->json(['status' => true, 'calendar' => $calendar], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAppointmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->all();
        $data['appointment_date'] = date('Y-m-d H:i:s', strtotime($request->appointment_date));
        $created = Appointment::create($data);
        return response()->json(['status' => true, 'appointment' => $created], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::with('matter')->find($id);
        return response()->json(['status' => true, 'appointment' => $appointment], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAppointmentRequest  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentRequest $request, $id)
    {
        $data = $request->all();
        $data['appointment_date'] = date('Y-m-d H:i:s', strtotime($request->appointment_date));
        Appointment::find($id)->update($request->all());
        return response()->json(['status' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
