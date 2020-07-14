
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
    format : 'Y-m-d H:i'
};




$(document).ready(function () {

    // appointments:
    $('#fieldStart').datetimepicker(dateTimePicker_i18n);
    $('#fieldEnd').datetimepicker(dateTimePicker_i18n);

    // vehicles:
    dateTimePicker_i18n.timepicker = false;
    dateTimePicker_i18n.format = 'Y-m-d';
    $('#techInspField').datetimepicker(dateTimePicker_i18n);
});
