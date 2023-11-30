<?php
include 'connect.php';
$id = isset($_POST['id']) ? $_POST['id'] : 'No ID received!';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class = "container">
        <div class = "box">criminals
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam fermentum arcu ac justo tincidunt, id interdum ligula ullamcorper. Suspendisse potenti. Phasellus at justo et turpis tincidunt vehicula. Duis sit amet vestibulum orci. Ut auctor libero eget purus tincidunt, vel interdum velit feugiat. Integer sed facilisis enim. Ut fermentum consectetur lectus, nec facilisis sem cursus in. Aenean eleifend velit a libero auctor ullamcorper. Suspendisse potenti. Donec vel purus nec justo ultricies congue.

Pellentesque fermentum, ligula vitae cursus congue, mauris orci ultricies lectus, non blandit tellus ligula ac elit. Aenean nec malesuada nisl. Praesent in lacus eget nisi ultricies ullamcorper at in arcu. Nullam non volutpat justo. Vivamus nec enim justo. In hac habitasse platea dictumst. Quisque id elit quis ligula auctor congue a vel orci. Phasellus nec efficitur odio, at fermentum erat. Vestibulum eu augue quis augue eleifend dictum.

Fusce auctor, dolor a commodo volutpat, ipsum metus laoreet neque, ut hendrerit quam justo non ipsum. Nunc eu odio et tortor tincidunt congue eu in felis. Quisque vestibulum libero vel velit congue, eu dignissim tortor suscipit. Integer eu elit bibendum, tincidunt nisl eget, biben

Pellentesque fermentum, ligula vitae cursus congue, mauris orci ultricies lectus, non blandit tellus ligula ac elit. Aenean nec malesuada nisl. Praesent in lacus eget nisi ultricies ullamcorper at in arcu. Nullam non volutpat justo. Vivamus nec enim justo. In hac habitasse platea dictumst. Quisque id elit quis ligula auctor congue a vel orci. Phasellus nec efficitur odio, at fermentum erat. Vestibulum eu augue quis augue eleifend dictum.
Pellentesque fermentum, ligula vitae cursus congue, mauris orci ultricies lectus, non blandit tellus ligula ac elit. Aenean nec malesuada nisl. Praesent in lacus eget nisi ultricies ullamcorper at in arcu. Nullam non volutpat justo. Vivamus nec enim justo. In hac habitasse platea dictumst. Quisque id elit quis ligula auctor congue a vel orci. Phasellus nec efficitur odio, at fermentum erat. Vestibulum eu augue quis augue eleifend dictum.
Pellentesque fermentum, ligula vitae cursus congue, mauris orci ultricies lectus, non blandit tellus ligula ac elit. Aenean nec malesuada nisl. Praesent in lacus eget nisi ultricies ullamcorper at in arcu. Nullam non volutpat justo. Vivamus nec enim justo. In hac habitasse platea dictumst. Quisque id elit quis ligula auctor congue a vel orci. Phasellus nec efficitur odio, at fermentum erat. Vestibulum eu augue quis augue eleifend dictum.



        </div>
        <div class = "box">crime</div>
        <div class = "box">judge</div>


    </div>

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .container {
            width: 90%;
            padding: 20px;
            margin: auto;
            display: flex;
            background: #ddd;
            justify-content: space-between;
            height: 100vh; /* Set the container height to 100% of the viewport height */
        }

        .box {
            flex: 1;
            height: 400px;
            padding: 20px;
            background: orange;
            border: 3px solid #ddd;
            max-width: 100%;
            transition: 1s;
            overflow: hidden;
        }

        .box:hover {
            background: #ff8000;
            overflow: auto;
        }

        .box-content {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
    
</body>
</html>