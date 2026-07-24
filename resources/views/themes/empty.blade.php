<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Portfolio Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="text-center px-4">
            <div class="mb-4">
                <i class="bi bi-braces text-primary" style="font-size: 4rem;"></i>
            </div>
            <h1 class="display-6 fw-bold mb-3">Welcome to Portfolio Builder</h1>
            <p class="lead text-muted mb-4">Please log in to set up your portfolio.</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Log In</a>
        </div>
    </div>
</body>
</html>
