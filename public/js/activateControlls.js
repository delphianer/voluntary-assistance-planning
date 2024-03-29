
// see https://xdsoft.net/jqplugins/datetimepicker/
let dateTimePicker_i18n = {
    i18n:{
        de:{
            months:[
                'Januar','Februar','März','April',
                'Mai','Juni','Juli','August',
                'September','Oktober','November','Dezember',
            ],
            dayOfWeek:[
                "So.", "Mo", "Di", "Mi",
                "Do", "Fr", "Sa.",
            ]
        }
    },
    timepicker:true,
    format : 'Y-m-d H:i:00'
};




$(document).ready(function () {

    // operationshifts + appointments
    $('#startDateTimeField').datetimepicker(dateTimePicker_i18n);
    $('#endDateTimeField').datetimepicker(dateTimePicker_i18n);

    // vehicles:
    dateTimePicker_i18n.timepicker = false;
    dateTimePicker_i18n.format = 'Y-m-d';
    $('#techInspField').datetimepicker(dateTimePicker_i18n);
    $('#certValidUntil').datetimepicker(dateTimePicker_i18n);
});
