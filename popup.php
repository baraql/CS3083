<?php
$id = isset($_POST['id']) ? $_POST['id'] : 'No ID received!';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Three Columns Layout</title>
    <style>
        /* Apply basic styling to the columns */
        .container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .column {
            width: 30%;
            background-color: #f0f0f0;
            padding: 20px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div>
        <p>Received ID:
            <?php echo $id; ?>
        </p>
    </div>
    <div class="container">
        <div class="column">
            <h2>Column 1</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="column">
            <h2>Column 2</h2>
            <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        <div class="column">
            <h2>Column 3</h2>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.</p>
        </div>
    </div>
</body>

</html>