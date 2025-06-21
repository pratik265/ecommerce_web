<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Manrope', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .error-container {
            max-width: 600px;
            padding: 40px;
        }
        .error-code {
            font-size: 10rem;
            font-weight: 700;
            color: #0d6efd;
            line-height: 1;
            text-shadow: 4px 4px 0px #e0e7ff;
        }
        .error-heading {
            font-size: 2.5rem;
            font-weight: 700;
            margin-top: 20px;
            color: #343a40;
        }
        .error-message {
            font-size: 1.1rem;
            color: #6c757d;
            margin-top: 15px;
            margin-bottom: 30px;
        }
        .btn-home {
            border-radius: 50rem;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 700;
            background-color: #0d6efd;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            background-color: #0a58ca;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-heading"><?php echo $heading; ?></h1>
        <p class="error-message"><?php echo $message; ?></p>
        <a href="/" class="btn-home">Go to Homepage</a>
    </div>
</body>
</html>