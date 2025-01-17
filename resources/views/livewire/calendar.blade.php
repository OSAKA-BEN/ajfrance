<main class="main-content mt-1 border-radius-lg min-vh-100">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-calendar">
                    <div class="card-body p-3">
                        <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="../../assets/js/plugins/fullcalendar.min.js"></script>
<script>
var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
    contentHeight: 'auto',
    initialView: "dayGridMonth",
    headerToolbar: {
        start: 'today prev,next',
        center: 'title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    selectable: false,
    editable: false,
    events: @json($events),
    views: {
        dayGridMonth: {
            titleFormat: {
                month: "long",
                year: "numeric"
            }
        },
        timeGridWeek: {
            titleFormat: {
                month: "long",
                year: "numeric",
                day: "numeric"
            },
            slotMinTime: '07:00:00',
            slotMaxTime: '21:00:00'
        },
        timeGridDay: {
            titleFormat: {
                month: "long",
                year: "numeric",
                day: "numeric"
            },
            slotMinTime: '07:00:00',
            slotMaxTime: '21:00:00'
        }
    },
    buttonText: {
        today: "Today",
        month: 'Month',
        week: 'Week',
        day: 'Day'
    },
    locale: 'ja'
});

calendar.render();
</script>
