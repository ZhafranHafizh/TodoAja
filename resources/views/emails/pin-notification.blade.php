<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isNewAccount ? 'Welcome to TodoAja' : 'Your TodoAja PIN' }}</title>
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
            background: linear-gradient(135deg, #0052cc 0%, #0747a6 100%);
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
        
        .welcome-message {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .welcome-message h2 {
            color: #172b4d;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 16px 0;
        }
        
        .welcome-message p {
            color: #6b778c;
            font-size: 16px;
            margin: 0;
        }
        
        .pin-container {
            background: #f4f5f7;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin: 32px 0;
            border: 2px solid #dfe1e6;
        }
        
        .pin-label {
            font-size: 14px;
            font-weight: 600;
            color: #6b778c;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .pin-code {
            font-size: 48px;
            font-weight: 700;
            color: #0052cc;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 82, 204, 0.1);
        }
        
        .pin-note {
            font-size: 12px;
            color: #97a0af;
            margin-top: 12px;
        }
        
        .instructions {
            background: #e3fcef;
            border-left: 4px solid #00875a;
            padding: 20px;
            border-radius: 8px;
            margin: 24px 0;
        }
        
        .instructions h3 {
            color: #006644;
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 12px 0;
        }
        
        .instructions ol {
            color: #172b4d;
            margin: 0;
            padding-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 8px;
        }
        
        .security-notice {
            background: #fff4e6;
            border-left: 4px solid #ff8b00;
            padding: 16px;
            border-radius: 8px;
            margin: 24px 0;
        }
        
        .security-notice p {
            color: #b25000;
            font-size: 14px;
            margin: 0;
            font-weight: 500;
        }
        
        .email-footer {
            background: #f4f5f7;
            padding: 24px 32px;
            text-align: center;
            border-top: 1px solid #dfe1e6;
        }
        
        .email-footer p {
            color: #6b778c;
            font-size: 14px;
            margin: 0;
        }
        
        .login-button {
            display: inline-block;
            background: #0052cc;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            margin: 16px 0;
            transition: background 0.2s ease;
        }
        
        .login-button:hover {
            background: #0747a6;
            color: white;
            text-decoration: none;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .email-header, .email-body, .email-footer {
                padding: 24px 20px;
            }
            
            .pin-code {
                font-size: 36px;
                letter-spacing: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🎯 TodoAja</h1>
            <p>Your Personal Productivity System</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            @if($isNewAccount)
                <div class="welcome-message">
                    <h2>Welcome to TodoAja! 🎉</h2>
                    <p>Your account has been successfully created. Here's your unique PIN to get started.</p>
                </div>
            @else
                <div class="welcome-message">
                    <h2>Your Login PIN</h2>
                    <p>Here's your TodoAja login PIN as requested.</p>
                </div>
            @endif
            
            <!-- PIN Display -->
            <div class="pin-container">
                <div class="pin-label">Your 4-Digit PIN</div>
                <div class="pin-code">{{ $pin }}</div>
                <div class="pin-note">Generated on {{ now()->format('M j, Y \a\t g:i A') }}</div>
            </div>
            
            <!-- Instructions -->
            <div class="instructions">
                <h3>🔐 How to Access Your Account</h3>
                <ol>
                    <li>Go to the TodoAja login page</li>
                    <li>Enter this 4-digit PIN: <strong>{{ $pin }}</strong></li>
                    <li>Click "Login" to access your dashboard</li>
                    <li>Start organizing your tasks and boosting productivity!</li>
                </ol>
            </div>
            
            @if($isNewAccount)
                <div style="text-align: center;">
                    <a href="{{ url('/login') }}" class="login-button">
                        🚀 Start Using TodoAja
                    </a>
                </div>
            @endif
            
            <!-- Security Notice -->
            <div class="security-notice">
                <p>
                    🔒 <strong>Security Notice:</strong> Keep this PIN secure and don't share it with anyone. 
                    This PIN provides full access to your TodoAja account.
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p>
                This email was sent to <strong>{{ $user->email }}</strong><br>
                If you didn't request this PIN, please ignore this email.
            </p>
            <p style="margin-top: 16px; font-size: 12px; color: #97a0af;">
                © {{ date('Y') }} TodoAja - Personal Productivity System
            </p>
        </div>
    </div>
</body>
</html>
