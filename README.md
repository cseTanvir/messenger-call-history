## Messenger Call History
Messenger Call History is a Laravel PHP web application that processes JSON data related to call statistics.

## Motivation
I needed to access the call history for one of my messenger chats, but I only had a JSON file and couldn't find a suitable solution to extract the data I needed. I stumbled upon some sites that demanded a lot of personal information, so I decided to create a solution for myself and others who might face a similar situation. I developed a Python script with visualization features, but then I thought I should share it with others. This led to the creation of the Messenger Call History Laravel application.
## Features
This is a Laravel PHP web application that processes JSON data related to call statistics. The application consists of two main routes: index() and process().

The index() method returns the view for the home page, which includes a form for uploading the JSON data file.

The process() method is called when the user submits the form with a file. It first validates that the file is in JSON format using Laravel's built-in validator. If the file is not in JSON format, an error message is returned to the user. If the file is in JSON format, the data is decoded and processed.

The process() method then computes various statistics from the call data, including the total duration of calls for each participant, the call duration per day for each participant, and the number of incoming and outgoing calls for each participant. Finally, the method returns a view that displays these statistics in a user-friendly format.

The HTML code for displaying the call statistics is contained in the call_details.blade.php file. This file includes a table that displays the call data, as well as several charts that show the call statistics in graphical form. The file also includes JavaScript code for exporting the call data table to a CSV file.

## Installation
To install this application, you need a minimum of PHP 8.1. Then run the following commands:
```
git clone https://github.com/csetanvir/messenger-call-history.git
cd messenger-call-history
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```


## Usage
To use the application, follow these steps:

 1. Download your Facebook message data in JSON format. Here's how you can do it:

    - Open your Facebook and go into Settings & Privacy > Settings
    - Go to Your Facebook Information > Download Your Information
    - Select the data range "All of my data", format "JSON" and Media Quality "High"
    - Select Messages only
    - Click on Create File
    - Facebook will create a zip file on their server and notify you when the file is ready to download.
 2. Once you have downloaded the JSON file, run the Messenger Call History application and upload the JSON file.

 3. The process() method will compute various statistics from the call data, including the total duration of calls for each participant, the call duration per day for each participant, and the number of incoming and outgoing calls for each participant.

 4. The application will display these statistics in a user-friendly format, including a table that displays the call data and several charts that show the call statistics in graphical form.

If you don't want to install the application, you can also visit [https://mch.csetanvir.com](https://mch.csetanvir.com/) to use it online.This app will be always free. We do not collect or save the uploaded file or information, so your privacy is 100% protected.
## Contributing
We encourage others to contribute to the Messenger Call History application. Here are some ways to contribute:

- Report any issues or bugs you find.
- Suggest new features or improvements.
- Submit pull requests to fix issues or add new features.
To contribute, follow these steps:

1. Fork this repository.
2. Create a new branch for your changes.
3. Make your changes and commit them.
4. Push your changes to your fork.
5. Submit a pull request.

We appreciate any contributions to the Messenger Call History application. Thank you for your interest in our project!


## License
This project is licensed under the MIT License.
## Contact
If you have any questions or feedback, feel free to contact me on:
- mail : tanvirhossain1994@gmail.com
- LinkedIn : https://www.linkedin.com/in/csetanvir 
- Twitter: https://twitter.com/cseTanvir
