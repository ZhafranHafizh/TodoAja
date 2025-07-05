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
        font-size: 20px;
        background: white;
        transition: all 0.2s ease;
        color: #172b4d;
        font-family: 'Courier New', monospace;
        text-align: center;
        letter-spacing: 4px;
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
    
    .jira-btn.ghost {
        background: transparent;
        color: #0052cc;
        border: none;
        padding: 8px 16px;
        font-size: 14px;
    }
    
    .jira-btn.ghost:hover {
        background: #f4f5f7;
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
    
    .resend-section {
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #dfe1e6;
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
    
    .resend-form {
        display: none;
        margin-top: 16px;
    }
    
    .resend-form.show {
        display: block;
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
            <h1>🎯 ToDoinAja</h1>
            <p>Enter your username and 4-digit PIN to continue</p>
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
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="username" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 6px;">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Username
                    </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="username" 
                        name="username" 
                        placeholder="Enter your username"
                        required 
                        autofocus 
                        value="{{ old('username') }}"
                        autocomplete="username"
                    >
                </div>
                
                <div class="form-group">
                    <label for="pin" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 6px;">
                            <rect x="3" y="11" width="18" height="10" rx="2" ry="2" stroke="currentColor" stroke-width="2"/>
                            <circle cx="12" cy="16" r="1" fill="currentColor"/>
                            <path d="M7 11V7a5 5 0 0110 0v4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        4-Digit PIN
                    </label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="pin" 
                        name="pin" 
                        placeholder="••••"
                        required 
                        inputmode="numeric" 
                        pattern="[0-9]*"
                        maxlength="4"
                        autocomplete="off"
                    >
                </div>
                
                <button type="submit" class="jira-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4m-5-4l5-5-5-5m5 5H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Login to Dashboard
                </button>
            </form>
            
            <div class="help-text">
                Enter your username and the 4-digit PIN from your email
            </div>
            
            <!-- Divider -->
            <div class="divider">
                <span>Need help?</span>
            </div>
            
            <!-- Help Options -->
            <div style="display: flex; gap: 8px; margin-bottom: 16px;">
                <button type="button" class="jira-btn ghost" onclick="toggleResendForm()" style="flex: 1;">
                    📧 Resend PIN
                </button>
                <a href="{{ route('register') }}" class="jira-btn ghost" style="flex: 1;">
                    ➕ New Account
                </a>
            </div>
            
            <!-- Features Link -->
            <div style="text-align: center; margin-bottom: 16px;">
                <a href="{{ route('features') }}" class="features-link">
                    ✨ View All Features & Security
                </a>
            </div>
            
            <!-- Resend PIN Form -->
            <div class="resend-form" id="resend-form">
                <form method="POST" action="{{ route('resend-pin') }}">
                    @csrf
                    <div class="form-group">
                        <label for="resend-username" class="form-label">Username</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="resend-username" 
                            name="username" 
                            placeholder="Enter your username"
                            required
                            style="font-family: Inter, sans-serif; letter-spacing: normal; text-align: left; font-size: 16px;"
                        >
                    </div>
                    <button type="submit" class="jira-btn secondary">
                        📨 Send New PIN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-focus username input
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('username').focus();
    });
    
    // Only allow numeric input for PIN
    document.getElementById('pin').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Toggle resend form
    function toggleResendForm() {
        const form = document.getElementById('resend-form');
        form.classList.toggle('show');
        if (form.classList.contains('show')) {
            document.getElementById('resend-username').focus();
        }
    }
    
    // Handle login form submission
    document.querySelector('form[action*="login"]').addEventListener('submit', function(e) {
        const username = document.getElementById('username').value;
        const pin = document.getElementById('pin').value;
        
        if (!username.trim()) {
            e.preventDefault();
            TodoAlert.warning('Username Required', 'Please enter your username');
            return;
        }
        
        if (pin.length !== 4) {
            e.preventDefault();
            TodoAlert.warning('Invalid PIN', 'Please enter a 4-digit PIN');
            return;
        }
        
        e.preventDefault();
        const loadingAlert = TodoAlert.loading('Verifying credentials...', 'Please wait while we authenticate you');
        this.submit();
    });
    
    // Handle resend PIN form submission
    document.querySelector('form[action*="resend-pin"]').addEventListener('submit', function(e) {
        e.preventDefault();
        const username = document.getElementById('resend-username').value;
        
        if (!username.trim()) {
            TodoAlert.warning('Username Required', 'Please enter your username');
            return;
        }
        
        TodoAlert.confirm(
            'Resend PIN',
            `Send a new PIN for username: ${username}?`,
            'Yes, send it!',
            'Cancel'
        ).then((result) => {
            if (result.isConfirmed) {
                const loadingAlert = TodoAlert.loading('Sending PIN...', 'Please wait while we send your new PIN');
                this.submit();
            }
        });
    });
</script>
@endsection
