<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Job Application</title>
</head>
<body>
    @component('mail::message')
    <h2>Hello,</h2>
    <p>You have received a new job application from:</p>
    <p>Name: {{ $data['name']  }}</p>
    <p>Email: {{ $data['email']  }}</p>
    <p>Phone Number: {{ $data['phone_num']  }}</p>
    <hr>
    <p>That applied the job for:</p>
    <p>Position: {{ $data['apply_position'] }}</p>
    <p>Location: {{ $career->location }}</p>
    <p>Specialization: {{ $career->specializations }}</p>
    <br/><br/>
    <p>Thank You</p>
    <p>Regards,</p>

    {{{ config('app.name') }}}

    @endcomponent
</body>
</html>

