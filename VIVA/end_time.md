```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <label for="duration">Lecture Hours</label>
        <input type="number" id="duration" name="duration" placeholder="3">
    </div>
    <div>
        <label for="start-time">Start Time</label>
        <input type="time" id="start-time" name="start-time">
    </div>
    <div>
        <label for="end-time">End Time</label>
        <input type="time" id="end-time" name="end-time" readonly>
    </div>

    <!-- replace below with your jquery file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function calculateEndTime() {
                var duration = parseFloat($('#duration').val());
                var startTime = $('#start-time').val();

                if (!isNaN(duration) && startTime) {
                    var startTimeParts = startTime.split(':');
                    var startHours = parseInt(startTimeParts[0]);
                    var startMinutes = parseInt(startTimeParts[1]);

                    var startDate = new Date();
                    startDate.setHours(startHours);
                    startDate.setMinutes(startMinutes);

                    var endDate = new Date(startDate.getTime() + duration * 60 * 60 * 1000);
                    
                    var endHours = String(endDate.getHours()).padStart(2, '0');
                    var endMinutes = String(endDate.getMinutes()).padStart(2, '0');

                    $('#end-time').val(endHours + ':' + endMinutes);
                }
            }

            $('#duration').on('input', calculateEndTime);
            $('#start-time').on('input', calculateEndTime);
        });
    </script>
</body>

</html>
