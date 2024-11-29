<!-- resources/views/reset-password.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<div style="max-width: 400px; margin: auto;">
    <form class="form-container" action="{{ url('api/customer/reset-password') }}" method="POST">
        @csrf
        <input type="text" class="hidden" name="_token" value="{{ $token }}">
        <input type="text" class="hidden" name="email" value="{{ $user->email }}">
        <div style="margin-bottom: 15px;">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required >
        </div>
        <div style="text-align: center;">
            <button type="submit" style="padding: 10px 20px; background-color: #4caf50; color: white; border: none; cursor: pointer; border-radius: 5px;">Reset Password</button>
        </div>
    </form>
</div>

</body>
</html>
