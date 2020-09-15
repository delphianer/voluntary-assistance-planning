<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

class CalendarJsonAPIController extends ControllerBase
{
    /**
     * initialize this Controller
     */
    public function initialize()
    {
    }

    public function getSchedulesAction()
    {
        $json = '[
                      {
                        "title": "All Day Event",
                        "start": "2020-09-01"
                      },
                      {
                        "title": "Long Event",
                        "start": "2020-09-07",
                        "end": "2020-09-10"
                      },
                      {
                        "id": "999",
                        "title": "Repeating Event",
                        "start": "2020-09-09T16:00:00-05:00"
                      },
                      {
                        "id": "999",
                        "title": "Repeating Event",
                        "start": "2020-09-16T16:00:00-05:00"
                      },
                      {
                        "title": "Conference",
                        "start": "2020-09-11",
                        "end": "2020-09-13"
                      },
                      {
                        "title": "Meeting",
                        "start": "2020-09-12T10:30:00-05:00",
                        "end": "2020-09-12T12:30:00-05:00"
                      },
                      {
                        "title": "Lunch",
                        "start": "2020-09-12T12:00:00-05:00"
                      },
                      {
                        "title": "Meeting",
                        "start": "2020-09-12T14:30:00-05:00"
                      },
                      {
                        "title": "Happy Hour",
                        "start": "2020-09-12T17:30:00-05:00"
                      },
                      {
                        "title": "Dinner",
                        "start": "2020-09-12T20:00:00"
                      },
                      {
                        "title": "Birthday Party",
                        "start": "2020-09-13T07:00:00-05:00"
                      },
                      {
                        "title": "Click for Google",
                        "url": "http://google.com/",
                        "start": "2020-09-28"
                      }
                    ]
                    ';
        $this->view->disable();
        //$this->response->setContentType('application/json', 'UTF-8');
        echo $json;

        return;
    }
}
