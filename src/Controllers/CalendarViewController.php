<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

class CalendarViewController extends ControllerBase
{
    private $_isPublic = true;
    /**
     * initialize this Controller
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
        $this->_isPublic = !$this->session->has('auth-identity');
    }

    public function indexAction()
    {
        if ($this->_isPublic) {
            $this->view->setVar('extraTitle', "Calendar view (Public)");
        } else {
            $this->view->setVar('extraTitle', "Calendar view");
        }

        $this->assets->collection("js")->addJs("/js/moment.js", true, true);
        $this->assets->collection("js")->addJs("/js/fullcalendar/main.min.js", true, true);
        $this->assets->collection("css")->addCss("/css/fullcalendar/main.min.css", true, true);
        $this->assets->collection("js")->addJs("/js/calendarViewInit.js", true, true);
        $this->assets->collection("css")->addCss("/css/calendarView.css", true, true);
    }
}
