<?php
include 'connect.php';
include 'queries.php'; 
?>

<?php
$criminal_id = '111111'; 
if (isset($_REQUEST['criminal_ID'])) {
    $criminal_id = $_REQUEST['criminal_ID'];
} else {
    echo "No ID received";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function deleteWithId(id) {
            if (window.confirm("Sure to delete crimes information with id \'" + id + "\'?")) {
                var form1 = document.createElement("form");
                form1.method = "POST";
                form1.action = "addCrimes.php?m=d&criminal_ID=<?PHP echo $criminal_id?>";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "crime_ID";
                input.value = id;

                form1.appendChild(input);
                document.body.appendChild(form1);
                form1.submit();
            }
        }
        function deleteSentence(id){
            if (window.confirm("Sure to delete sentence information with id \'" + id + "\'?")) {
                var form1 = document.createElement("form");
                form1.method = "POST";
                form1.action = "addSentences.php?m=d&criminal_ID=<?PHP echo $criminal_id?>";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "sentence_ID";
                input.value = id;

                form1.appendChild(input);
                document.body.appendChild(form1);
                form1.submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">


            <!-- ----------------------------------------------------------------------------------->
            <!-- ----------------------------------------------------------------------------------->
            <!--                               CRIMINAL                                           -->
            <!-- ----------------------------------------------------------------------------------->
            <!-- ----------------------------------------------------------------------------------->

        <div class="column"> 

        <div class = "box" onclick="toggleJudges()"> 
        <h2>Criminal ID: <?php  echo $criminal_id;?>
        <a href="addCrimes.php?criminal_ID=<?php echo $criminal_id; ?>"><button>Add Alias</button></a>
        </h2>

        <?php

        $sql = "SELECT * FROM criminals WHERE criminal_ID = '" . mysqli_real_escape_string($con, $criminal_id) . "'";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $criminal = mysqli_fetch_assoc($result); // Fetch the data as an associative array
            echo '<p>Name: ' . $criminal['criminal_name_first'] . ' ' . $criminal['criminal_name_last'] .  '</p>';
            echo '<p>Address: ' . $criminal['criminal_street'] . ', ' . $criminal['criminal_city'] . ', ' . $criminal['criminal_zip'] . '</p>';
            echo '<p>Phone: ' . $criminal['criminal_phone'] .  '</p>';
            echo '<p>Violation Status: ' . $criminal['criminal_violent_status'] .  '</p>';
            echo '<p>Probation Status: ' . $criminal['criminal_probation_status'] .  '</p>';


            //----------------------------------------------------------------------------------->
            //                              ALIAS                                              -->  
            //----------------------------------------------------------------------------------->
          
            $sql = "SELECT * FROM alias WHERE criminal_ID = '" . mysqli_real_escape_string($con, $criminal_id) . "'";
            $result = mysqli_query($con, $sql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Access the data from the current row using $row
                    echo '<div class="box4" style="font-family: Fira Sans; line-height: 1.5;">';
                    echo '<h3>' . $row['alias'] . '</h3>';
                    echo '<button class="popup-button" onclick="deleteWithId(' . $row['alias_ID'] . ');">Delete</button>';
                    echo '</div>'; 
                }
            } else {
                // Handle the case when no rows are found
            }

            
           
            

        } else {
            echo 'No criminal found with the specified ID.';
        }




        ?>
        
        </div><!-- ENDS CRIMINAL ID-->

        <div class = "column "> 

            <!-- ----------------------------------------------------------------------------------->
            <!-- ----------------------------------------------------------------------------------->
            <!--                                      SENTENCING                                  -->
            <!-- ----------------------------------------------------------------------------------->
            <!-- ----------------------------------------------------------------------------------->

            <h2>Sentencing 
            <a href="addSentences.php?criminal_ID=<?php echo $criminal_id; ?>"><button>Add</button></a>
            </h2>

            <?php
                $sql = "SELECT * FROM sentences WHERE criminal_ID = '" . mysqli_real_escape_string($con, $criminal_id) . "'";
                $result = mysqli_query($con, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($sentence = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="boxSentencing" style="font-family: Fira Sans;line-height: 1.5;">
                        <h3>Sentence ID: <?php echo $sentence['sentence_ID']; ?></h3>
                        <p>Sentence Type: <?php echo $sentence['sentence_type']; ?></p>
                        <p>Probation Officer ID: <?php echo $sentence['prob_ID']; ?></p>
                        <p>Start Date: <?php echo $sentence['start_date']; ?></p>
                        <p>End Date: <?php echo $sentence['end_date']; ?></p>
                        <p>Violations: <?php echo $sentence['violations']; ?></p>
                        <a href="addSentences.php?m=e&criminal_ID=<?php echo $criminal_id; ?>&sentence_ID=<?php echo $sentence['sentence_ID']; ?>">
                            <button class="popup-button">Edit</button>
                        </a>
                    
                        <button class="popup-button" onclick="deleteSentence(<?php echo $sentence['sentence_ID']; ?>);">Delete</button>

                    </div>

                    <!-- ------------------------------------------------------------ -->
                    <!-- ------------------------------------------------------------ -->
                    <!--        DELETE SENTENCES POPUP                                -->
                    <!-- ------------------------------------------------------------ -->
                    <!-- ------------------------------------------------------------ -->

                    <div class="popup" id="popup-sentence">
                        <h2>Confirm Deletion</h2>
                        <p>Are you sure you want to delete this Sentence?</p>
                        <button onclick="confirmDelete('popup-sentence')">Yes</button>
                        <button onclick="closePopup('popup-sentence')">No</button>
                    </div>
                <?php
                    }
                } 
            ?>

        </div>
        </div>

        <div class="column">



        <!-- ----------------------------------------------------------------------------------->
        <!-- ----------------------------------------------------------------------------------->
        <!--                                      CRIMES                                      -->
        <!-- ----------------------------------------------------------------------------------->
        <!-- ----------------------------------------------------------------------------------->


        <h2> CRIMES       
        <a href="addCrimes.php?criminal_ID=<?php echo $criminal_id; ?>"><button>Add</button></a>
        </h2>


        <?php

        //SHOW EACH POSSIBLE CRIME THE CRIMINAL COULD HAVE COMMITTED 
        $sql = "SELECT * FROM crimes WHERE criminal_ID = '" . mysqli_real_escape_string($con, $criminal_id) . "'";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($crime = mysqli_fetch_assoc($result)) {
                echo '<div class="box2" style="font-family: Fira Sans; line-height: 1.5;">';
                echo '<h3>Crime ID: ' . $crime['crime_ID'] . '</h3>';
                echo '<p>Crime Classification: ' . $crime['crime_classification'] . '</p>';
                echo '<p>Date Charged: ' . $crime['date_charged'] . '</p>';
                echo '<p>Crime Status: ' . $crime['crime_status'] . '</p>';
                echo '<p>Hearing Date: ' . $crime['hearing_date'] . '</p>';
                echo '<p>Appeal Deadline: ' . $crime['appeal_cut_date'] . '</p>';
               
                echo '<a href="addCrimes.php?m=e&criminal_ID=' . $criminal_id . '&crime_ID=' . $crime['crime_ID'] . '">';
               //TO CHANGE 
                echo '<button class="popup-button">Edit</button>';
                echo '</a>';
        
                // Add the Delete button
                echo '<button class="popup-button" onclick="deleteWithId(' . $crime['crime_ID'] . ');">Delete</button>';
        
                



                /* FOR EACH OF THE CRIME SHPOW CRIME OFFICERS, APPEALS, AND CRIME CHARGES */
             

                /* ---------------------------CRIME OFFICERS--------------------------- */ 
                
                echo '<div class="box3" id = "crimeOfficers">';
                echo '<h4>';
                echo 'CRIME OFFICERS';
                echo '<a href="addco.php?m=a&criminal_ID=' . $criminal_id . '&crime_ID=' . $crime['crime_ID'] . '">';
                echo '<button class="popup-button">Add Crime Officers</button>';
                echo '</a>';
                echo '</h4>';
        


                
                $crimeOfficersQuery = "SELECT * FROM crime_officers WHERE crime_ID = '" . mysqli_real_escape_string($con, $crime['crime_ID']) . "'";
                $crimeOfficersResult = mysqli_query($con, $crimeOfficersQuery);

                if ($crimeOfficersResult && mysqli_num_rows($crimeOfficersResult) > 0) {

                    //get names of all officers associated with this crime 
                    while ($crimeOfficer = mysqli_fetch_assoc($crimeOfficersResult)) {
                        echo '<div class = "boxfinal">'; 
                        echo '<p>Office ID: ' . $crimeOfficer['officer_ID'] . '</p>';
                        $officerID = $crimeOfficer['officer_ID'];
                        $officerQuery = "SELECT * FROM officers WHERE officer_ID = '" . mysqli_real_escape_string($con, $officerID) . "'";
                        $officerResult = mysqli_query($con, $officerQuery);

                        //get the said officer's first and last name 
                        if ($officerResult && mysqli_num_rows($officerResult) > 0) {
                            $officerData = mysqli_fetch_assoc($officerResult);
                            echo '<p>Officer Name: ' . $officerData['officer_name_first'] . ' ' . $officerData['officer_name_last'] . '</p>';
                        }

                        //add 
                        echo '<form method="post" action="addco_functions.php">'; //form 1 
                        echo '<input type="hidden" name="crime_ID" value="' . $crime['crime_ID'] . '">';
                        echo '<input type="hidden" name="officer_ID" value="' . $officerID . '">';


                        //delete 
                        echo '<input type="hidden" name="m" value="d">'; //u &m idk when and where this will be important 
                        echo '<button type="submit" id="coDelete" onclick="return confirm(\'Are you sure you want to delete this crime officer?\')">Delete</button>';
                        echo '</form>';


                        //edit 
                        echo '<a href="addco.php?m=u&criminal_ID=' . $criminal_id . '&crime_ID=' . $crime['crime_ID'] . '&officer_ID=' . $officerID .  '">';
                        echo '<input type="hidden" name="officer_ID" value="' . $officerID .'">';
                        echo '<input type="hidden" name="crime_ID" value="' . $crime['crime_ID'] . '">';
                        echo '<input type="hidden" name="m" value="u">'; //u &m idk when and where this will be important 
                        echo '<button class="popup-button">Edit Crime Officer</button>';
                        echo '</a>';

 
                        echo '</div>'; //closes crime officers boxfinal 



                    }
                } 
                echo '</div>';
                /* ---------------------------CRIME OFFICERS--------------------------- */ 


               

                /* ---------------------------APPEALS---------------------------------- */ 
                echo '<div class="box3" id="appeals">';
                echo '<h4>';
                echo 'APPEALS ';
                echo '<a href="addAppeals.php?m=a&criminal_ID=' . $criminal_id . '&crime_ID=' . $crime['crime_ID'] . '">';
                echo '<button class="popup-button">Add Appeals</button>';
                echo '</a>';
                echo '</h4>';

                $appealsQuery = "SELECT * FROM appeals WHERE crime_ID = '" . mysqli_real_escape_string($con, $crime['crime_ID']) . "'";
                $appealsResult = mysqli_query($con, $appealsQuery);

                if ($appealsResult && mysqli_num_rows($appealsResult) > 0) {
                    while ($appeals = mysqli_fetch_assoc($appealsResult)) {
                        echo '<div class = "boxfinal">'; 
                        echo '<p>Appeal ID: ' . $appeals['appeal_ID'] . '</p>';
                        echo '<p>Filing Date: ' . $appeals['filing_date'] . '</p>';
                        echo '<p>Hearing Date: ' . $appeals['hearing_date'] . '</p>';
                        echo '<p>Appeal Status: ' . $appeals['appeal_status'] . '</p>';
                      
                        //What does this do? 
                        echo '<form method="post" action="appeals_function.php">'; //form 1 
                        echo '<input type="hidden" name="appeal_ID" value="' . $appeals['appeal_ID'] . '">';
                        echo '<input type="hidden" name="criminal_ID" value="' . $criminal_id . '">';
                        //echo delete 
                        echo '<input type="hidden" name="m" value="d">';
                        echo '<button type="submit" id="appealsDelete" onclick="return confirm(\'Are you sure you want to delete this appeal?\')">Delete</button>';
                        echo '</form>'; //form 2 

                        //edit appeals
                        echo '<a href="addAppeals.php?m=u&criminal_ID=' . $criminal_id . '&crime_ID=' . $crime['crime_ID'] . '&appeal_ID=' . $appeals['appeal_ID'] . '&appeal_status=' . $appeals['appeal_status'] . '&filing_date=' . $appeals['filing_date'] . '&hearing_date=' . $appeals['hearing_date'] . '">';
                        echo '<input type="hidden" name="appeal_ID" value="' . $appeals['appeal_ID'] . '">';
                        echo '<input type="hidden" name="criminal_ID" value="' . $criminal_id . '">';
                        echo '<input type="hidden" name="m" value="u">';
                        echo '<button class="popup-button">Edit Appeal</button>';
                        echo '</a>';
                        echo '</div>'; 


                    }
                } 
                echo '</div>'; 
                /* ---------------------------APPEALS---------------------------------- */ 




                /* ---------------------------CHARGES---------------------------------- */ 
                echo '<div class="box3" id = "charges">';
                echo '<h4>'; 
                echo 'CHARGES ';
                echo '<a href="addcharges.php?m=a&criminal_ID=' . $criminal_id . '&crime_ID=' . $crime['crime_ID'] . '">';
                echo '<button class="popup-button">Add Charges</button>';
                echo '</a>';               
                echo '</h4>';

                $chargesQuery = "SELECT * FROM crime_charges WHERE crime_ID = '" . mysqli_real_escape_string($con, $crime['crime_ID']) . "'";
                $chargesResult = mysqli_query($con, $chargesQuery);
    
                if ($chargesResult && mysqli_num_rows($chargesResult) > 0) {
                    while ($charges = mysqli_fetch_assoc($chargesResult)) {
                        echo '<div class = "boxfinal" id = "indivisualCharges">'; 
    
                        echo '<p>Charge ID: ' . $charges['charge_ID'] . '</p>';
                        echo '<p>Charge Status: ' . $charges['charge_status'] . '</p>';
                        echo '<p>Fine Amount: ' . $charges['fine_amount'] . '</p>';
                        echo '<p>Court Fee: ' . $charges['court_fee'] . '</p>';
                        echo '<p>Amount Paid: ' . $charges['amount_paid'] . '</p>';
                        echo '<p>Due Date: ' . $charges['pay_due_date'] . '</p>';


                        //what does this do? 
                        echo '<form method="post" action="addcharges.php">'; //form 1 
                        echo '<input type="hidden" name="charge_ID" value="' . $charges['charge_ID'] . '">';
                        echo '<input type="hidden" name="criminal_ID" value="' . $criminal_id . '">';
                        echo '<input type="hidden" name="crime_ID" value="' . $crime['crime_ID'] . '">';

                        //echo charges 
                        echo '<input type="hidden" name="m" value="d">';
                        echo '<button type="submit" id="chargesDelete" onclick="return confirm(\'Are you sure you want to delete this Charge?\')">Delete</button>';
                        echo '</form>'; //form 2 


                        //edit charges
                        echo '<a href="addcharges.php?m=u&criminal_ID=' . $criminal_id . '&crime_ID=' . $crime['crime_ID'] . '&charge_ID=' . $charges['charge_ID'] . '">';
                        echo '<input type="hidden" name="charge_ID" value="' . $charges['charge_ID'] . '">';
                        echo '<input type="hidden" name="crime_ID" value="' . $crime['crime_ID'] . '">';
                        echo '<input type="hidden" name="m" value="u">';
                        echo '<button class="popup-button">Edit Charges</button>';
                        echo '</a>';
                        echo '</div>'; 
    
                    }
                } 
                echo '</div>';  //closing box 3 charges 
     
                /* ---------------------------CHARGES---------------------------------- */ 

                




                echo '</div>'; // Closing box2
            }
        } 
?>

            
   

        </div>

    </div>


'




'
<script>
    function addCrimeStuff(crimeID, identifier) {
        var form = document.createElement("form");
        form.method = "POST";
        if (identifier == "appeals") {
            form.action = "addAppeals.php";



        }
        else if (identifier == "crimeOfficers") {
            form.action = "addCrimeOfficers.php";



        }
        else {
            form.action = "addCharges.php";

        }



        var inputCrimeID = document.createElement("input");
        inputCrimeID.type = "hidden";
        inputCrimeID.name = "crimeID";
        inputCrimeID.value = crimeID;

        form.appendChild(inputCrimeID);
        document.body.appendChild(form);

        form.submit();
    }
</script>








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
            max-width: 950px; 

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
            height: auto; /* Set a specific height */
            width: 100%; /* Set a specific width */
            padding: 20px;
            background: #EEE0C9;
            margin-bottom: 10px;
            overflow: hidden;
            border-radius: 2vw ;
            border: 3px; 
            min-height: 600px; 
            transition: 1s;



        }

        .box:hover {
            overflow: auto;
            background: #F1F0E8 

        }

        .box2:hover {
            overflow: auto;
            background: #F1F0E8; 
        }

        .box-content {
            max-height: 300px;
            overflow-y: auto;
        }

        .column:hover {           

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
            background: #FFF4E3;
            margin-bottom: 10px;
            overflow: hidden;
            overflow-y: auto; /* Enable vertical scrolling */
            border-radius: 1vw ;
            height: auto; 
            min-height: 100px; 



        }


        .box3:hover {
            overflow: auto;
            background: #96B6C5 
            border-radius: 2vw ;

        }

        .box4 {
            height: 50px; /* Set a specific height */
            width: 100%; /* Set a specific width */
            padding: 20px;
            background: #FFF4E3;
            margin-bottom: 10px;
            overflow: hidden;
            overflow-y: auto; /* Enable vertical scrolling */
            border-radius: 1vw ;
            height: auto; 
            min-height: 50px; 



        }


        .box4:hover {
            overflow: auto;
            background: #96B6C5 
            border-radius: 2vw ;

        }


        .popup-delete {
        width: 50%;
        max-height: 50%;
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
        overflow-y: auto;
        transition: transform 0.4s, top 0.4s, visibility 0s linear 0.4s; /* Added visibility transition delay */
        border-radius: 2vw;
    }

    .popup.open-popup {
        visibility: visible;
        top: 50%;
        transform: translate(-50%, -50%) scale(1);
    }


    .boxSentencing{
            height: 200px; /* Set a specific height */
            width: 100%; /* Set a specific width */
            padding: 20px;
            background: #EEE0C9;
            margin-bottom: 10px;
            overflow: hidden;
            border-radius: 2vw ;
            border: 3px; 



        }


        .boxSentencing:hover {
            overflow: auto;
            background: #F1F0E8 
        }

        .boxfinal{
            height: auto
            height-min: 100px; /* Set a specific height */
            width: 100%; /* Set a specific width */
            padding: 20px;
            background: #FFF4E3;
            margin-bottom: 10px;
            overflow: hidden;
            border-radius: 1vw ;
            border: 3px; 
            transition: 1s;




        }


        .boxfinal:hover {
            overflow: auto;
            background: #fbfbf8; 
        }


    </style>
</body>
</html>
