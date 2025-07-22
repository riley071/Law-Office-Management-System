<?php
session_start();
if (!isset($_SESSION['attorney_id'])) {
    header("Location: login.php");
    exit();
}
$attorney_id = $_SESSION['attorney_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointment Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }

        h3 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #343a40;
        }

        .calendar-container {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #343a40;
        }

        .fc-button {
            background-color: #007bff !important;
            border: none !important;
            border-radius: 5px !important;
            color: white !important;
        }

        .fc-button:hover {
            background-color: #0056b3 !important;
        }

        .fc-event {
            background-color: #17a2b8 !important;
            border: none !important;
            border-radius: 4px;
            padding: 2px 4px;
            font-size: 0.85rem;
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-body p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="calendar-container">
        <h3 class="text-center">📅 My Appointment Calendar</h3>
        <div id="calendar"></div>
    </div>
</div>

<!-- Modal for event details -->
<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Appointment Details</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body" id="appointmentDetails">
        <!-- Appointment info will be loaded here -->
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: "auto",
        events: 'load_appointments.php',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventClick: function (info) {
            var event = info.event;
            var details = `
                <p><strong>Client:</strong> ${event.extendedProps.client}</p>
                <p><strong>Service:</strong> ${event.extendedProps.service}</p>
                <p><strong>Status:</strong> ${event.extendedProps.status}</p>
                <p><strong>Date:</strong> ${event.start.toLocaleString()}</p>
            `;
            $('#appointmentDetails').html(details);
            $('#appointmentModal').modal('show');
        }
    });
    calendar.render();
});
</script>
</body>
</html>
