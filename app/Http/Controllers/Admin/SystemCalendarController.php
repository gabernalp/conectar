<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SystemCalendarController extends Controller
{
    public $sources = [
        [
            'model'      => '\App\CourseSchedule',
            'date_field' => 'start_date',
            'field'      => 'id',
            'prefix'     => 'Ciclo de retos',
            'suffix'     => 'inicia hoy',
            'route'      => 'admin.course-schedules.edit',
        ],
        [
            'model'      => '\App\EventsSchedule',
            'date_field' => 'date',
            'field'      => 'id',
            'prefix'     => 'Evento',
            'suffix'     => '',
            'route'      => 'admin.events-schedules.edit',
        ],
    ];

    public function index()
    {
        $events = [];

        foreach ($this->sources as $source) {
            foreach ($source['model']::all() as $model) {
                $crudFieldValue = $model->getAttributes()[$source['date_field']];

                if (!$crudFieldValue) {
                    continue;
                }

                $events[] = [
                    'title' => trim($source['prefix'] . " " . $model->{$source['field']}
                        . " " . $source['suffix']),
                    'start' => $crudFieldValue,
                    'url'   => route($source['route'], $model->id),
                ];
            }
        }

        return view('admin.calendar.calendar', compact('events'));
    }
}
