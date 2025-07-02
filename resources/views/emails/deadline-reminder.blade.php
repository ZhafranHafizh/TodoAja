<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reminderType === '30_minutes' ? 'Urgent: Task Deadline Approaching!' : 'Task Deadline Reminder' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #172b4d;
            margin: 0;
            padding: 0;
            background-color: #f4f5f7;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            @if($reminderType === '30_minutes')
                background: linear-gradient(135deg, #de350b 0%, #bf2600 100%);
            @else
                background: linear-gradient(135deg, #ffab00 0%, #ff8b00 100%);
            @endif
            color: white;
            padding: 32px;
            text-align: center;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .email-header p {
            margin: 8px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        
        .email-body {
            padding: 32px;
        }
        
        .reminder-message {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .reminder-message h2 {
            color: #172b4d;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 16px 0;
        }
        
        .reminder-message p {
            color: #6b778c;
            font-size: 16px;
            margin: 0;
        }
        
        .task-container {
            background: #f4f5f7;
            border-radius: 12px;
            padding: 24px;
            margin: 32px 0;
            border-left: 4px solid {{ $reminderType === '30_minutes' ? '#de350b' : '#ffab00' }};
        }
        
        .task-title {
            font-size: 20px;
            font-weight: 600;
            color: #172b4d;
            margin: 0 0 12px 0;
        }
        
        .task-meta {
            display: grid;
            gap: 12px;
            margin-bottom: 16px;
        }
        
        .task-meta-item {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #6b778c;
        }
        
        .task-meta-item strong {
            color: #172b4d;
            margin-right: 8px;
            min-width: 80px;
        }
        
        .deadline-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            @if($reminderType === '30_minutes')
                background: #ffebe6;
                color: #de350b;
            @else
                background: #fff4e6;
                color: #ff8b00;
            @endif
        }
        
        .task-description {
            background: white;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #dfe1e6;
            margin-top: 16px;
        }
        
        .task-description h4 {
            margin: 0 0 8px 0;
            font-size: 14px;
            font-weight: 600;
            color: #172b4d;
        }
        
        .task-description p {
            margin: 0;
            font-size: 14px;
            color: #6b778c;
            line-height: 1.5;
        }
        
        .action-button {
            display: inline-block;
            background: #0052cc;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            margin: 24px 0;
            transition: background-color 0.2s;
        }
        
        .action-button:hover {
            background: #0747a6;
            color: white;
            text-decoration: none;
        }
        
        .footer {
            background: #f4f5f7;
            padding: 24px 32px;
            text-align: center;
            border-top: 1px solid #dfe1e6;
        }
        
        .footer p {
            margin: 0;
            font-size: 12px;
            color: #97a0af;
        }
        
        .footer a {
            color: #0052cc;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        .priority-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
            @if($reminderType === '30_minutes')
                background: #de350b;
            @else
                background: #ffab00;
            @endif
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .email-header, .email-body, .footer {
                padding: 24px 16px;
            }
            
            .task-container {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>
                @if($reminderType === '30_minutes')
                    🚨 Urgent Deadline Alert
                @else
                    ⏰ Deadline Reminder
                @endif
            </h1>
            <p>
                @if($reminderType === '30_minutes')
                    Your task deadline is in 30 minutes!
                @else
                    Your task deadline is approaching in 3 days
                @endif
            </p>
        </div>
        
        <div class="email-body">
            <div class="reminder-message">
                <h2>
                    @if($reminderType === '30_minutes')
                        Action Required Now!
                    @else
                        Don't Forget!
                    @endif
                </h2>
                <p>
                    @if($reminderType === '30_minutes')
                        This is an urgent reminder that your task deadline is approaching very soon.
                    @else
                        This is a friendly reminder about your upcoming task deadline.
                    @endif
                </p>
            </div>
            
            <div class="task-container">
                <div class="task-title">
                    <span class="priority-indicator"></span>
                    {{ $activity->title }}
                </div>
                
                <div class="task-meta">
                    <div class="task-meta-item">
                        <strong>Deadline:</strong>
                        <span class="deadline-badge">
                            {{ \Carbon\Carbon::parse($activity->deadline)->format('M j, Y \a\t g:i A') }}
                        </span>
                    </div>
                    
                    @if($activity->category)
                    <div class="task-meta-item">
                        <strong>Category:</strong>
                        <span style="color: {{ $activity->category->color ?? '#6b778c' }};">
                            {{ $activity->category->name }}
                        </span>
                    </div>
                    @endif
                    
                    <div class="task-meta-item">
                        <strong>Status:</strong>
                        <span style="text-transform: capitalize;">{{ $activity->status }}</span>
                    </div>
                    
                    @if($reminderType === '30_minutes')
                    <div class="task-meta-item">
                        <strong>Time Left:</strong>
                        <span style="color: #de350b; font-weight: 600;">
                            {{ \Carbon\Carbon::parse($activity->deadline)->diffForHumans() }}
                        </span>
                    </div>
                    @endif
                </div>
                
                @if($activity->description)
                <div class="task-description">
                    <h4>Task Description:</h4>
                    <p>{{ Str::limit($activity->description, 200) }}</p>
                </div>
                @endif
            </div>
            
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}" class="action-button">
                    @if($reminderType === '30_minutes')
                        Complete Task Now
                    @else
                        View Task Details
                    @endif
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>
                This is an automated reminder from 
                <a href="{{ config('app.url') }}"><strong>ToDoinAja</strong></a>
                - Your Personal Productivity System
            </p>
            <p style="margin-top: 8px;">
                Stay organized, stay productive! 🚀
            </p>
        </div>
    </div>
</body>
</html>
