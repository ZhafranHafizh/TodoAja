<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ToDoinAja') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
        }
    </style>
</head>
<body>
    <main>
        @yield('content')
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 Flash Messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                TodoAlert.success('{{ session('success') }}');
            @endif
            
            @if(session('error'))
                TodoAlert.error('{{ session('error') }}');
            @endif
            
            @if(session('warning'))
                TodoAlert.warning('{{ session('warning') }}');
            @endif
            
            @if(session('info'))
                TodoAlert.info('{{ session('info') }}');
            @endif
            
            @if($errors->any())
                TodoAlert.error('Validation Error', '{{ $errors->first() }}');
            @endif
        });
    </script>
</body>
</html>
