<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Email</title>
</head>
<body>
    @component('mail::message')
    <h2>Hello,</h2>
    <p>You have received a new enquiry from:</p>
    <p>Name: {{ $data['name']  }}</p>
    <p>Email: {{ $data['email']  }}</p>
    <p>Phone Number: {{ $data['phone_num'] }}</p>
    <p>Subject: {{ $data['subject'] }}</p>
    <p>Message: {{ $data['message']  }}</p>
    <p>Thank You</p>
    <p>Regards,</p>

    {{ config('app.name') }}

    @endcomponent
</body>
</html>

