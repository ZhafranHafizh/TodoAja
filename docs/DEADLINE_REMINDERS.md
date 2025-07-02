# Deadline Reminder System

## Overview
The ToDoinAja deadline reminder system automatically sends email notifications to users when their tasks are approaching their deadlines. This helps ensure important tasks are not forgotten and deadlines are met.

## How It Works

### Reminder Types
1. **3-Day Advance Notice**
   - Sent 3 days before the task deadline
   - Provides early warning for planning and preparation
   - Uses orange/amber color scheme in emails

2. **30-Minute Urgent Alert**
   - Sent 30 minutes before the task deadline
   - Final urgent reminder for immediate attention
   - Uses red color scheme to emphasize urgency

### Technical Implementation

#### Database Schema
- `activity_reminders` table tracks sent reminders
- Prevents duplicate reminders for the same task and type
- Records when each reminder was sent

#### Scheduling
- Command runs every 5 minutes: `reminders:send-deadline-reminders`
- Uses Laravel's task scheduler with proper overlap prevention
- Runs in background without blocking other operations

#### Email Templates
- Professional HTML templates matching the application's design
- Responsive design for mobile devices
- Includes task details, deadline information, and direct links

#### Query Logic
- Finds tasks with deadlines within specific time windows
- Excludes completed tasks from reminders
- Only sends to users with valid email addresses
- Prevents duplicate reminders using database constraints

### Configuration

#### Environment Variables
Make sure these are set in your `.env` file:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="ToDoinAja"
```

#### Scheduler Setup
For production, add this to your server's crontab:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

For development, run:
```bash
php artisan schedule:work
```

### Testing the System

#### Create Test Tasks
```bash
# Create a task with deadline in 3 days
php artisan test:create-deadline-task --type=3days

# Create a task with deadline in 30 minutes
php artisan test:create-deadline-task --type=30minutes
```

#### Manual Reminder Check
```bash
# Check for and send any pending reminders
php artisan reminders:send-deadline-reminders
```

#### Verify Scheduler
```bash
# List all scheduled commands
php artisan schedule:list
```

### Monitoring

#### Check Sent Reminders
You can monitor sent reminders in the database:
```sql
SELECT ar.*, a.title, a.deadline, u.email 
FROM activity_reminders ar
JOIN activities a ON ar.activity_id = a.id
JOIN users u ON a.user_id = u.id
ORDER BY ar.sent_at DESC;
```

#### Command Output
The reminder command provides detailed output:
- ✓ Success messages for sent reminders
- ✗ Error messages for failed sends
- Summary of total reminders sent

### Error Handling
- Failed email sends are logged but don't prevent other reminders
- Database constraints prevent duplicate reminder records
- Graceful handling of missing user emails or invalid activities

### Performance Considerations
- Efficient queries with proper indexes on deadline and user_id
- Time window flexibility (±1 hour for 3-day, ±5 minutes for 30-minute)
- Background processing to avoid blocking the main application
- Overlap prevention to avoid multiple instances running simultaneously

## Files Involved

### Models
- `app/Models/Activity.php` - Extended with reminders relationship
- `app/Models/ActivityReminder.php` - Tracks sent reminders
- `app/Models/User.php` - User email management

### Commands
- `app/Console/Commands/SendDeadlineReminders.php` - Main reminder logic
- `app/Console/Commands/CreateTestDeadlineTask.php` - Testing helper

### Mail
- `app/Mail/DeadlineReminder.php` - Mail class for reminders
- `resources/views/emails/deadline-reminder.blade.php` - Email template

### Database
- `database/migrations/*_create_activity_reminders_table.php` - Reminder tracking table

### Configuration
- `bootstrap/app.php` - Scheduler configuration
