<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
<p><strong>Hi {{$mailData['name']}}</strong>,</p>

<p>Forget Password.?</p>
<p>We received a request to reset the password for your account.</p>
<p>Your request submited successfully. Kindly use following otp to signin your account.</p>

<p> Your account credentials are following -<br>
    <ul>
        <li><strong>OTP:</strong> {{$mailData['otp']}}</li>
    </ul>
</p>

<p><strong>Write Your Day</strong><br>
    <br>
    writeyourday@gmail.com</p>
</div>

</body>
</html>