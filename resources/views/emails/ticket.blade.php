<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Event Ticket</title>
</head>
<body>
    <h1>Your Ticket for {{ $eventDetails['title'] }}</h1>
    
    <p>Hello {{ $eventDetails['userName'] }},</p>
    
    <p>Thank you for your reservation. Your ticket is attached to this email as a PDF file.</p>
    
    <h3>Event Details:</h3>
    <p><strong>Date:</strong> {{ $eventDetails['date'] }}</p>
    <p><strong>Location:</strong> {{ $eventDetails['address'] }}</p>
    <p><strong>Room:</strong> {{ $eventDetails['room'] }}</p>
    
    <p>We look forward to seeing you at the event!</p>
    
    <p>Best regards,<br>Event Team</p>
</body>
</html>