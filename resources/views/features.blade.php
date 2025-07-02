@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    body { 
        background: #f4f5f7; 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: #172b4d;
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }
    
    .features-container {
        min-height: 100vh;
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .features-header {
        text-align: center;
        margin-bottom: 48px;
        background: white;
        border-radius: 12px;
        padding: 48px 32px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        border: 1px solid #dfe1e6;
    }
    
    .features-header h1 {
        font-size: 42px;
        font-weight: 700;
        margin: 0 0 16px 0;
        background: linear-gradient(135deg, #0052cc 0%, #0747a6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .features-header p {
        font-size: 20px;
        color: #6b778c;
        margin: 0 0 32px 0;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .feature-badges {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .feature-badge {
        background: #e6f2ff;
        color: #0052cc;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #b3d4ff;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 32px;
        margin-bottom: 48px;
    }
    
    .feature-section {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        border: 1px solid #dfe1e6;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .feature-section:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    
    .feature-section h2 {
        font-size: 24px;
        font-weight: 600;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .feature-icon {
        font-size: 32px;
        padding: 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
    }
    
    .feature-icon.security {
        background: linear-gradient(135deg, #de350b 0%, #bf2600 100%);
    }
    
    .feature-icon.tasks {
        background: linear-gradient(135deg, #0052cc 0%, #0747a6 100%);
    }
    
    .feature-icon.automation {
        background: linear-gradient(135deg, #00875a 0%, #006644 100%);
    }
    
    .feature-icon.design {
        background: linear-gradient(135deg, #6554c0 0%, #5243aa 100%);
    }
    
    .feature-icon.performance {
        background: linear-gradient(135deg, #ffab00 0%, #ff8b00 100%);
    }
    
    .feature-icon.collaboration {
        background: linear-gradient(135deg, #ff5630 0%, #de350b 100%);
    }
    
    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .feature-list li {
        padding: 12px 0;
        border-bottom: 1px solid #f4f5f7;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    
    .feature-list li:last-child {
        border-bottom: none;
    }
    
    .feature-check {
        color: #00875a;
        font-weight: bold;
        font-size: 16px;
        margin-top: 2px;
        flex-shrink: 0;
    }
    
    .feature-text {
        flex: 1;
    }
    
    .feature-text strong {
        color: #172b4d;
        display: block;
        margin-bottom: 4px;
    }
    
    .feature-text span {
        color: #6b778c;
        font-size: 14px;
    }
    
    .security-highlights {
        background: linear-gradient(135deg, #ffebe6 0%, #fff4e6 100%);
        border: 2px solid #ff8b00;
        border-radius: 12px;
        padding: 24px;
        margin: 32px 0;
    }
    
    .security-highlights h3 {
        color: #de350b;
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .security-highlights ul {
        margin: 0;
        padding-left: 0;
        list-style: none;
    }
    
    .security-highlights li {
        padding: 8px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .security-highlights .shield {
        color: #de350b;
        font-weight: bold;
    }
    
    .action-buttons {
        display: flex;
        gap: 16px;
        justify-content: center;
        margin-top: 48px;
        flex-wrap: wrap;
    }
    
    .jira-btn {
        background: #0052cc;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 16px 32px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: 2px solid transparent;
    }
    
    .jira-btn:hover {
        background: #0747a6;
        text-decoration: none;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 82, 204, 0.3);
    }
    
    .jira-btn.secondary {
        background: white;
        color: #0052cc;
        border: 2px solid #0052cc;
    }
    
    .jira-btn.secondary:hover {
        background: #e6f2ff;
        color: #0052cc;
        border-color: #0052cc;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 82, 204, 0.2);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
        margin: 32px 0;
    }
    
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 24px;
        text-align: center;
        border: 1px solid #dfe1e6;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .stat-number {
        font-size: 36px;
        font-weight: 700;
        color: #0052cc;
        display: block;
    }
    
    .stat-label {
        font-size: 14px;
        color: #6b778c;
        margin-top: 8px;
    }
    
    @media (max-width: 768px) {
        .features-container {
            padding: 16px;
        }
        
        .features-header {
            padding: 32px 24px;
        }
        
        .features-header h1 {
            font-size: 32px;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        
        .feature-section {
            padding: 24px;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .jira-btn {
            width: 100%;
            max-width: 300px;
            justify-content: center;
        }
    }
</style>

<div class="features-container">
    <!-- Header Section -->
    <div class="features-header">
        <h1>✨ ToDoinAja Features</h1>
        <p>A comprehensive personal productivity system designed with security, efficiency, and user experience in mind.</p>
        
        <div class="feature-badges">
            <span class="feature-badge">🔐 Bank-Level Security</span>
            <span class="feature-badge">📧 Smart Reminders</span>
            <span class="feature-badge">🎨 Modern Design</span>
            <span class="feature-badge">⚡ Lightning Fast</span>
            <span class="feature-badge">📱 Mobile Ready</span>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-number">🔒</span>
            <div class="stat-label">256-bit Encryption</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">⚡</span>
            <div class="stat-label">Real-time Updates</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">📧</span>
            <div class="stat-label">Auto Reminders</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">🎯</span>
            <div class="stat-label">Zero Setup</div>
        </div>
    </div>

    <!-- Features Grid -->
    <div class="features-grid">
        <!-- Security Features -->
        <div class="feature-section">
            <h2>
                <div class="feature-icon security">🔐</div>
                Security & Privacy
            </h2>
            <ul class="feature-list">
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>PIN Hashing with bcrypt</strong>
                        <span>Your 4-digit PIN is encrypted using industry-standard bcrypt hashing, making it virtually impossible to reverse-engineer even if someone gains database access.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Private User Data Isolation</strong>
                        <span>Every task, category, and log is tied to your account. Other users cannot see or access your data, ensuring complete privacy.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Secure Email Verification</strong>
                        <span>Unique email enforcement with secure PIN delivery via encrypted SMTP connections.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Session Management</strong>
                        <span>Secure session handling with automatic timeouts and proper logout functionality.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>CSRF Protection</strong>
                        <span>Built-in protection against Cross-Site Request Forgery attacks on all forms.</span>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Task Management -->
        <div class="feature-section">
            <h2>
                <div class="feature-icon tasks">📋</div>
                Task Management
            </h2>
            <ul class="feature-list">
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Smart Task Creation</strong>
                        <span>Create tasks with titles, descriptions, deadlines, categories, and optional links for comprehensive tracking.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Visual Status Indicators</strong>
                        <span>Color-coded status system: To-Do (blue), In Progress (orange), Completed (green) with visual deadline warnings.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Quick Category Assignment</strong>
                        <span>Instantly assign or change task categories with one-click AJAX-powered buttons.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Deadline Sorting & Filtering</strong>
                        <span>Automatically sort tasks by deadline urgency with overdue, urgent, and upcoming indicators.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Expandable Task Details</strong>
                        <span>Click to expand tasks and view full descriptions, links, and metadata without leaving the page.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Time Tracking</strong>
                        <span>Track start times, end times, and duration for productivity analysis.</span>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Automation Features -->
        <div class="feature-section">
            <h2>
                <div class="feature-icon automation">🤖</div>
                Smart Automation
            </h2>
            <ul class="feature-list">
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>3-Day Advance Reminders</strong>
                        <span>Automatic email notifications sent 3 days before deadlines to help with planning and preparation.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>30-Minute Urgent Alerts</strong>
                        <span>Final urgent reminders sent 30 minutes before deadlines with red-coded emergency styling.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Duplicate Prevention</strong>
                        <span>Smart system prevents sending multiple reminders for the same deadline, avoiding email spam.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Background Processing</strong>
                        <span>Reminders run automatically in the background every 5 minutes without affecting app performance.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>PIN Auto-Generation</strong>
                        <span>Secure 4-digit PINs are automatically generated and sent via professional email templates.</span>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Design & UX -->
        <div class="feature-section">
            <h2>
                <div class="feature-icon design">🎨</div>
                Modern Design
            </h2>
            <ul class="feature-list">
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Jira-Inspired Interface</strong>
                        <span>Professional, clean design inspired by popular project management tools with intuitive navigation.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Responsive Mobile Design</strong>
                        <span>Fully responsive layout that works perfectly on desktop, tablet, and mobile devices.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>SweetAlert2 Integration</strong>
                        <span>Beautiful, customizable alerts and confirmations instead of basic browser popups.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Color-Coded Categories</strong>
                        <span>Custom color selection for categories with visual consistency throughout the interface.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Professional Email Templates</strong>
                        <span>Beautiful HTML email templates with responsive design and consistent branding.</span>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Performance & Reliability -->
        <div class="feature-section">
            <h2>
                <div class="feature-icon performance">⚡</div>
                Performance
            </h2>
            <ul class="feature-list">
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Laravel 11 Framework</strong>
                        <span>Built on the latest Laravel framework for maximum performance, security, and maintainability.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Database Optimization</strong>
                        <span>Efficient database queries with proper indexing and relationship management for fast data retrieval.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>AJAX-Powered Updates</strong>
                        <span>Real-time updates without page reloads for category assignments and status changes.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Caching Strategy</strong>
                        <span>Smart caching for configuration and views to ensure lightning-fast page loads.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Error Handling</strong>
                        <span>Robust error handling with graceful fallbacks and user-friendly error messages.</span>
                    </div>
                </li>
            </ul>
        </div>

        <!-- User Experience -->
        <div class="feature-section">
            <h2>
                <div class="feature-icon collaboration">👤</div>
                User Experience
            </h2>
            <ul class="feature-list">
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Zero-Setup Authentication</strong>
                        <span>No complex passwords to remember - just your email and a simple 4-digit PIN.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>PIN Resend Functionality</strong>
                        <span>Lost your PIN? Request a new one instantly with the built-in resend feature.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>User Context Awareness</strong>
                        <span>Dashboard shows your email and personalizes the experience based on your account.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Intuitive Navigation</strong>
                        <span>Clear navigation with breadcrumbs, action buttons, and logical information hierarchy.</span>
                    </div>
                </li>
                <li>
                    <span class="feature-check">✓</span>
                    <div class="feature-text">
                        <strong>Accessibility Features</strong>
                        <span>Keyboard navigation, screen reader support, and high contrast design elements.</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Security Highlights Box -->
    <div class="security-highlights">
        <h3>
            🛡️ Your Data Security Guarantee
        </h3>
        <ul>
            <li>
                <span class="shield">🔒</span>
                <strong>PINs are hashed using bcrypt</strong> - Even if someone gains database access, your PIN cannot be recovered
            </li>
            <li>
                <span class="shield">🔐</span>
                <strong>Email addresses are unique</strong> - No duplicate accounts, ensuring data integrity
            </li>
            <li>
                <span class="shield">👥</span>
                <strong>Complete data isolation</strong> - Your tasks and categories are private to your account only
            </li>
            <li>
                <span class="shield">📧</span>
                <strong>Secure email delivery</strong> - PINs are sent via encrypted SMTP connections
            </li>
            <li>
                <span class="shield">🛡️</span>
                <strong>Laravel security features</strong> - CSRF protection, SQL injection prevention, and XSS protection
            </li>
        </ul>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('register') }}" class="jira-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="8.5" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                <line x1="20" y1="8" x2="20" y2="14" stroke="currentColor" stroke-width="2"/>
                <line x1="23" y1="11" x2="17" y2="11" stroke="currentColor" stroke-width="2"/>
            </svg>
            Get Started Free
        </a>
        <a href="{{ route('login') }}" class="jira-btn secondary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4m-5-4l5-5-5-5m5 5H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Already Have Account
        </a>
    </div>
</div>
@endsection
