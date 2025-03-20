<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event Ticket</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.5;
        }
        .ticket {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            border-radius: 10px;
            overflow: hidden;
        }
        .ticket-header {
            background-color: #3490dc;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .ticket-body {
            padding: 20px;
        }
        .ticket-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .ticket-footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 14px;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .ticket-id {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <h1>{{ $eventDetails['title'] }}</h1>
            <h3>{{ $eventDetails['category'] }}</h3>
        </div>
        
        <div class="ticket-body">
            <div class="ticket-info">
                <div>
                    <p><strong>Date & Time:</strong> {{ $eventDetails['date'] }}</p>
                    <p><strong>Location:</strong> {{ $eventDetails['address'] }}</p>
                    <p><strong>Room:</strong> {{ $eventDetails['room'] }}</p>
                </div>
                <div>
                    <p><strong>Ticket ID:</strong> <span class="ticket-id">{{ $ticket->id }}</span></p>
                    <p><strong>Ticket Type:</strong> {{ ucfirst($ticket->tariff_type) }}</p>
                    <p><strong>Attendee:</strong> {{ $eventDetails['userName'] }}</p>
                </div>
            </div>
            
            <div class="event-description">
                <h4>Event Description:</h4>
                <p>{{ $eventDetails['description'] }}</p>
            </div>
            
            <div class="qr-code">
                <!-- QR code will be generated with the ticket ID -->
                <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(200)->generate($ticket->id)) }}" alt="Ticket QR Code">
            </div>
        </div>
        
        <div class="ticket-footer">
            <p>Please present this ticket at the entrance. This ticket is valid for one person only.</p>
        </div>
    </div>
</body>
</html>