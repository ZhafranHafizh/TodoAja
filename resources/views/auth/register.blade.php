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
    
    .auth-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }
    
    .auth-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        border: 1px solid #dfe1e6;
        width: 100%;
        max-width: 400px;
        overflow: hidden;
    }
    
    .auth-header {
        background: linear-gradient(135deg, #0052cc 0%, #0747a6 100%);
        color: white;
        padding: 32px 24px;
        text-align: center;
    }
    
    .auth-header h1 {
        font-size: 28px;
        font-weight: 600;
        margin: 0 0 8px 0;
    }
    
    .auth-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 16px;
    }
    
    .auth-body {
        padding: 32px 24px;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #172b4d;
        margin-bottom: 8px;
    }
    
    .form-control {
        width: 100%;
        border: 2px solid #dfe1e6;
        border-radius: 8px;
        padding: 14px 16px;
        font-size: 16px;
        background: white;
        transition: all 0.2s ease;
        color: #172b4d;
        font-family: inherit;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        border-color: #0052cc;
        box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1);
        outline: none;
    }
    
    .jira-btn {
        width: 100%;
        background: #0052cc;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 14px 24px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .jira-btn:hover {
        background: #0747a6;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }
    
    .jira-btn.secondary {
        background: #f4f5f7;
        color: #42526e;
        border: 1px solid #dfe1e6;
    }
    
    .jira-btn.secondary:hover {
        background: #ebecf0;
        color: #172b4d;
        border-color: #c1c7d0;
    }
    
    .alert {
        border: none;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .alert.success {
        background: #e3fcef;
        color: #006644;
        border-left: 4px solid #00875a;
    }
    
    .alert.error {
        background: #ffebe6;
        color: #bf2600;
        border-left: 4px solid #de350b;
    }
    
    .divider {
        text-align: center;
        margin: 24px 0;
        position: relative;
        color: #6b778c;
        font-size: 14px;
    }
    
    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #dfe1e6;
        z-index: 1;
    }
    
    .divider span {
        background: white;
        padding: 0 16px;
        position: relative;
        z-index: 2;
    }
    
    .help-text {
        font-size: 14px;
        color: #6b778c;
        text-align: center;
        margin-top: 16px;
    }
    
    .features-link {
        color: #0052cc;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        padding: 8px 16px;
        border-radius: 6px;
        transition: all 0.2s;
        display: inline-block;
        border: 1px solid transparent;
    }
    
    .features-link:hover {
        background: #e6f2ff;
        border-color: #b3d4ff;
        text-decoration: none;
        color: #0052cc;
    }
    
    .feature-list {
        background: #f4f5f7;
        border-radius: 8px;
        padding: 20px;
        margin: 24px 0;
    }
    
    .feature-list h3 {
        font-size: 16px;
        font-weight: 600;
        color: #172b4d;
        margin: 0 0 12px 0;
    }
    
    .feature-list ul {
        margin: 0;
        padding-left: 20px;
        color: #6b778c;
        font-size: 14px;
    }
    
    .feature-list li {
        margin-bottom: 6px;
    }
    
    @media (max-width: 480px) {
        .auth-container {
            padding: 16px;
        }
        
        .auth-header, .auth-body {
            padding: 24px 20px;
        }
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <h1>🎯 Join ToDoinAja</h1>
            <p>Create your personal productivity account</p>
        </div>
        
        <!-- Body -->
        <div class="auth-body">
            @if(session('success'))
                <div class="alert success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
                        <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
                        <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <div>
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- What you'll get -->
            <div class="feature-list">
                <h3>✨ What you'll get:</h3>
                <ul>
                    <li>Personal task management dashboard</li>
                    <li>Category organization with colors</li>
                    <li>Deadline tracking and reminders</li>
                    <li>Simple PIN-based secure access</li>
                </ul>
            </div>
            
            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 6px;">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="email" 
                        name="email" 
                        placeholder="Enter your email address"
                        required 
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                    >
                </div>
                
                <button type="submit" class="jira-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Create Account & Get PIN
                </button>
            </form>
            
            <div class="help-text">
                We'll send a 4-digit PIN to your email address.<br>
                No passwords needed - just your PIN!
            </div>
            
            <!-- Divider -->
            <div class="divider">
                <span>Already have an account?</span>
            </div>
            
            <!-- Back to Login -->
            <a href="{{ route('login') }}" class="jira-btn secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Login
            </a>
            
            <!-- Features Link -->
            <div style="text-align: center; margin-top: 16px;">
                <a href="{{ route('features') }}" class="features-link">
                    ✨ View All Features & Security
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-focus email input
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('email').focus();
    });
    
    // Handle registration form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        
        if (!email) {
            TodoAlert.warning('Email Required', 'Please enter your email address');
            return;
        }
        
        if (!email.includes('@') || !email.includes('.')) {
            TodoAlert.warning('Invalid Email', 'Please enter a valid email address');
            return;
        }
        
        TodoAlert.confirm(
            'Create Account',
            `Create a new ToDoinAja account for ${email}? We'll send a 4-digit PIN to this email address.`,
            'Yes, create account!',
            'Cancel'
        ).then((result) => {
            if (result.isConfirmed) {
                const loadingAlert = TodoAlert.loading('Creating Account...', 'Please wait while we set up your account and send your PIN');
                this.submit();
            }
        });
    });
</script>
@endsection
