
<?php
include 'connect.php';
include 'queries.php'; 
$id = '111111';
?>

<?php

// popup.php

// Check if the 'id' parameter is set in the POST request
if (isset($_POST['id'])) {
    // Retrieve the value of 'id'
    $id = $_POST['id'];

    // Now you can use $id as needed in your script

    // For example, you can echo it to display the value
} else {
    // Handle the case where 'id' is not set
    echo "No ID received";
}
?>















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">

        <div class="column"> 

        <div class = "box" onclick="toggleJudges()"> 
        <h2>Criminal 
        <a href="addCrimes.php?id=<?php echo $id; ?>"><button>Update</button></a>

        </h2>
        </div>
        
        
        <div class = "column ">

            <h2>Sentencing 
            <a href="addSentences.php?id=<?php echo $id; ?>"><button>Add</button></a>
            </h2>


            <?php
            $sql = "SELECT * FROM sentences WHERE criminal_ID = '" . mysqli_real_escape_string($con, $id) . "'";
            $result = mysqli_query($con, $sql);

            // Check if there are any sentencing entries
            if ($result && mysqli_num_rows($result) > 0) {
                while ($sentence = mysqli_fetch_assoc($result)) {
                    echo '<div class="box2" style="font-family: Fira Sans;line-height: 1.5;">';
                    echo '<h3>Sentence ID: ' . $sentence['sentence_ID'] . '</h3>';
                    echo '<p>Sentence Type: ' . $sentence['sentence_type'] . '</p>';
                    echo '<p>Probation Officer ID: ' . $sentence['prob_ID'] . '</p>';
                    echo '<p>Start Date: ' . $sentence['start_date'] . '</p>';
                    echo '<p>End Date: ' . $sentence['end_date'] . '</p>';
                    echo '<p>Violations: ' . $sentence['violations'] . '</p>';
                    echo '</div>';
                }
            } else {
                // Display a message or do nothing if no sentencing entries exist
            }
            ?>


        </div>
        </div>

        <div class="column">












        

        <h2> CRIMES       
        <a href="addCrimes.php?id=<?php echo $id; ?>"><button>Add</button></a>
        </h2>
            
        <?php
            $sql = "SELECT * FROM crimes WHERE criminal_ID = '" . mysqli_real_escape_string($con, $id) . "'";
            $result = mysqli_query($con, $sql);

            if ($result) {
                while($crime = mysqli_fetch_assoc($result)) {
            ?>
                <div class="box2" style="font-family: Fira Sans;line-height: 1.5;">
                    <h3>Crime ID: <?php echo $crime['crime_ID']; ?></h3>
                    <p>Crime Classification: <?php echo $crime['crime_classification']; ?></p>
                    <p>Date Charged: <?php echo $crime['date_charged']; ?></p>
                    <p>Crime Status: <?php echo $crime['crime_status']; ?></p>
                    <p>Hearing Date: <?php echo $crime['hearing_date']; ?></p>
                    <button class="popup-button" onclick="openPopup(<?php echo $crime['crime_ID']; ?>)">View Details</button>
                </div>

                <!-- Include the popup HTML -->
                <div class="popup" id="popup-<?php echo $crime['crime_ID']; ?>">
                    <h2>Crime ID: <?php echo $crime['crime_ID']; ?>
                
                </h2>
                    
        
                    <!-- Box3 Type 1 -->
                    <div class="box3" style="font-family: 'Fira Sans', sans-serif;">
                    <h2>Crime Officers



                    </h2>

                    </h2>


                    <!-- Add your content here -->
                </div>

                     
                    <!-- Box3 Type 2 -->
                    <div class="box3" style="font-family: 'Fira Sans', sans-serif;">
                        <h2>Appeals

                     
                        </h2>

                    </div>

                    <!-- Box3 Type 3 -->
                    <div class="box3" style="font-family: 'Fira Sans', sans-serif;">
                        <h2>Charges

                    
                        </h2>

                        </h2>
                        <!-- Add your content here -->
                    </div>

                    <button onclick="closePopup(<?php echo $crime['crime_ID']; ?>)">Done</button>

                    <div class="popup" id="popup-<?php echo $crime['crime_ID']; ?>">
                
                </div>



                </div>




                
            <?php
                }
            }
            ?>



        </div>

        <script>
            function openPopup(crimeID) {
                var popup = document.getElementById("popup-" + crimeID);
                popup.classList.add("open-popup");
            }

            function closePopup(crimeID) {
                var popup = document.getElementById("popup-" + crimeID);
                popup.classList.remove("open-popup");
            }

            
        </script>




    </div>
































    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%; /* Set the body and html height to 100% */
        }

        .container {
            width: 70%;
            padding: 20px;
            margin: 30px auto ; /* Add top and bottom margin, keep auto for horizontal centering */
            display: flex;
            background: #ddd;
            justify-content: space-between;
            height: 90vh; /* Set the container height to 100% of the viewport height */

        }


        .column {
            flex: 1;
            max-height: 100%;
            padding: 20px;
            background: #96B6C5;
            max-width: 100%;
            transition: 1s;
            overflow: auto;  
            flex-direction: column; /* Set flex direction to column for vertical stacking */


        }

        .box {
            height: 300px;
            padding: 20px;
            background: #EEE0C9;
            max-width: 100%;
            transition: 1s;
            overflow: hidden;
            transition: 1s;
            overflow: hidden;
            margin-bottom: 10px; 
            border-radius: 2vw ;



        }

        .box2 {
            height: 200px; /* Set a specific height */
            width: 100%; /* Set a specific width */
            padding: 20px;
            background: #EEE0C9;
            margin-bottom: 10px;
            overflow: hidden;
            border-radius: 2vw ;


        }

        .box:hover {
            overflow: auto;
            background: #F1F0E8 

        }

        .box2:hover {
            overflow: auto;
            background: #F1F0E8 
        }

        .box-content {
            max-height: 300px;
            overflow-y: auto;
        }

        .column:hover {
            background: #ADC4CE;
            overflow: auto;
        }

        .column-content {
            max-height: 300px;
            overflow-y: auto;
        }

        .table-container {
            text-align: center; /* Center-align the content */
            margin: auto; /* Center the container horizontally */
            max-width: 100%; /* Ensure the container doesn't exceed the viewport width */
        }

        table {
            width: 100%; /* Make the table take the full width of its container */
        }



        .popup {
        width: 30%;
        max-height: 80%; /* Set a maximum height for scrollability */
        background: #fff;
        border-radius: 6px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.1);
        text-align: center;
        padding: 30px;
        color: #333;
        visibility: hidden;
        overflow-y: auto; /* Enable vertical scrolling */
        transition: transform 0.4s, top 0.4s;
        border-radius: 2vw ;

    }

        .open-popup {
            visibility: visible;
            top: 50%;
            transform: translate(-50%, -50%) scale(1);
        }

        .box3 {
            height: 200px; /* Set a specific height */
            width: 100%; /* Set a specific width */
            padding: 20px;
            background: #EEE0C9;
            margin-bottom: 10px;
            overflow: hidden;
            overflow-y: auto; /* Enable vertical scrolling */
            border-radius: 2vw ;



        }


        .box3:hover {
            overflow: auto;
            background: #F1F0E8 
            border-radius: 2vw ;

        }

        .box3:hover {
            overflow: auto;
            background: #F1F0E8 
        }

    </style>
</body>
</html>
