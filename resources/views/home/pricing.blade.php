<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
    <p>Test</p>
    <ol>
        @foreach ($users as $user)
            <li>This is user {{ $user->id }}, {{ $user->username }}</li>
        @endforeach
    </ol>
    <ol>
        @foreach ($reminders as $reminder)
            <li>This is reminder {{ $reminder->id }}, {{ $reminder->message }}, from user {{ $reminder->user_id }}</li>
        @endforeach
    </ol>
</body>
</html>