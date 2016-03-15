<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Message from the contact form</h2>
        <p>From: {{ isset($email) ? $email : 'No email given' }}</p>
		<div>{{ $body }}</div>
	</body>
</html>
