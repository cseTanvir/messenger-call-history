<!DOCTYPE html>
<html>
<head>
    <title>Call Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dark.css') }}">
</head>
<body>
@if(isset($call_data))
    <div class="container-fluid ">
        <div class="mb-5 pb-5">
            <!-- Output the total call duration for each participant -->
            @foreach($total_durations as $participant => $duration)
                <h1 class="noselect text-align-center">Total call duration for <span class="text-warning">{{ $participant }}</span> : <span class="text-info">{{ $duration }}</span> seconds</h1>
            @endforeach
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill">
                <div class="d-flex flex-wrap align-content-center">
                    <h2 class="noselect mx-auto">All call details:</h2>
                    <br>
                    <button id="export1" data-table="call_details" class="noselect mx-auto">
                        <img src="{{asset('images/csv-icon-12.jpg')}} " alt="csv" height="32px"> Export
                    </button>
                </div>


                <table class="noselect " id="call_details">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Caller</th>
                        <th>Receiver</th>
                        <th>Duration</th>
                        <th>Call Type</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($call_data as $participant => $calls)

                        @foreach($calls as $call)
                            <tr>
                                <td>{{ $call['Date']->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $call['Sender'] }}</td>
                                <td>{{ $call['Receiver'] }}</td>
                                <td>{{ $call['Duration'] }}</td>
                                <td>{{ $call['type'] }}</td>
                            </tr>
                        @endforeach

                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-2 flex-fill" >
                <!-- Output the call durations per day for each participant -->
                <div class="justify-content-center">
                    <div class="d-flex flex-wrap align-content-center">
                        <h2 class="noselect mx-auto">Daily call summary:</h2>
                        <button id="export2" data-table="call_summary" class="noselect mx-auto">
                            <img src="{{asset('images/csv-icon-12.jpg')}} " alt="csv" height="32px"> Export
                        </button>
                    </div>

                </div>

                <table class="noselect" id="call_summary">
                    <thead>
                    <tr>

                        <th>Date</th>
                        <th>Caller</th>
                        <th>Duration in seconds</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($durations_per_day as $participant => $days)
                        @foreach($days as $day => $duration)
                            <tr>
                                <td>{{ $day }}</td>
                                <td>{{ $participant }}</td>
                                <td>{{ $duration }}</td>
                            </tr>
                        @endforeach
                    @endforeach


                    </tbody>
                </table>

            </div>

        </div>


    </div>
@endif
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="{{asset('js/tabletocsv.js')}}"></script>

<script>
    function pad(num) {
        return ('0' + num).slice(-2);
    }

    $('#export1, #export2').on('click', function () {
        var tableId = $(this).attr('data-table');
        const now = new Date();
        var formattedDate = `${pad(now.getDate())}_${pad(now.getMonth() + 1)}_${now.getFullYear().toString()}_${pad(now.getHours())}_${pad(now.getMinutes())}`;
        $('#' + tableId).tableToCsv({
            fileName: $('#' + tableId).attr('id') + '_' + formattedDate
        });
    });
</script>
</body>
</html>
