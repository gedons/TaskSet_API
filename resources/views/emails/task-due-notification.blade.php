<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Due Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        .task-details {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .task-details p {
            margin: 0;
        }

        .task-details p strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Task Due Notification</h1>
        <div class="task-details">
            <p><strong>Task Title:</strong> {{ $task->title }}</p>
            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
            <p><strong>Description:</strong> {{ $task->description }}</p>
        </div>
        <p>This is a notification to inform you that the above task is due. Please take the necessary action.</p>
    </div>
</body>
</html>
