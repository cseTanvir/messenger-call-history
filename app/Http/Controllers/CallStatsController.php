<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;


class CallStatsController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function process(Request $request)
    {
        $data = [
            'file' => 'mimetypes:application/json,text/plain'
        ];
        $message = [
            'file.mimetypes' => 'The file must be JSON.'
        ];
        $validator = Validator::make((array)$request->all(), $data, $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (!$request->hasFile('file')) {
            return Redirect::back()->withErrors(['error' => 'No file was uploaded']);
        }

        // Get the uploaded file
        $file = $request->file('file');

        // Check if the file is a valid JSON format
        $data = json_decode(file_get_contents($file), true);
        try {
            if (!isset($data['participants'])) {
                throw new Exception('The JSON file does not have the valid structure.');
            }

            // Get the names of the participants from the JSON file
            $participants = array_column($data['participants'], 'name');

            // Rest of the code to process the JSON file

        } catch (Exception $e) {
            return Redirect::back()->withErrors(['error' => $e->getMessage()]);
        }
        $call_data = array_fill_keys($participants, []);
        // Process each message in the JSON file
        foreach ($data['messages'] as $message) {
            // Check if the message is a call

            //new json structure provided by facebook
            if (!isset($message['type'])) {
                if (isset($message['call_duration'])) {
                    $call_data = $this->processMessage($message, $participants, $call_data);
                }
            }
            //new json structure provided by facebook
            if (isset($message['type']) && $message['type'] == 'Call') {
                $call_data = $this->processMessage($message, $participants, $call_data);
            }
        }

        // Calculate the total call duration for each participant
        $total_durations = array_map(function ($participant_calls) {
            return array_reduce($participant_calls, function ($acc, $call) {
                return $acc + $call['Duration'];
            }, 0);
        }, $call_data);

        // Calculate the call durations per day for each participant
        $durations_per_day = array_map(function ($participant_calls) {
            $days = [];
            foreach ($participant_calls as $call) {
                $date = $call['Date'];
                $day = $date->format('Y-m-d');
                if (!array_key_exists($day, $days)) {
                    $days[$day] = 0;
                }
                $days[$day] += $call['Duration'];
            }
            return $days;
        }, $call_data);

        return view('call_details', compact('call_data', 'total_durations', 'durations_per_day'));
    }


    private function processMessage($message, $participants, $call_data)
    {
        try {
            if (!array_key_exists('call_duration', $message) || !array_key_exists('sender_name', $message) || !array_key_exists('timestamp_ms', $message) || !array_key_exists('content', $message)) {
                throw new Exception('The JSON file does not have the valid structure.');
            }
            // Get the call duration in seconds
            $duration = $message['call_duration'];
            // Get the sender's name
            $sender = $message['sender_name'];
            // Get the receiver's name (the other participant in the call)
            $receiver = array_values(array_diff($participants, [$sender]))[0];
            // Convert the timestamp to a datetime object
            $date = DateTime::createFromFormat('U.u', $message['timestamp_ms'] / 1000);
            // Add the call data to the appropriate array
            $type = $message['content'];

            if (strpos($type, 'missed') !== false && strpos($type, 'call') !== false && strpos($type, 'video') === false) {
                $type = 'Missed call (Audio)';
            } elseif (strpos($type, 'called') !== false) {
                $type = 'Audio Call';
            } elseif (strpos($type, 'video') !== false && strpos($type, 'ended') !== false) {
                $type = 'Video Call';
            } elseif (strpos($type, 'missed') !== false && strpos($type, 'video') !== false) {
                $type = 'Missed call (Video)';
            }

            array_push($call_data[$sender], [
                'Date' => $date,
                'Sender' => $sender,
                'Receiver' => $receiver,
                'Duration' => $duration,
                'type' => $type,
            ]);

            return $call_data;


        } catch (Exception $e) {
            return Redirect::back()->withErrors(['error' => $e->getMessage()]);
        }

    }
}
