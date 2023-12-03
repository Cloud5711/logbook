<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <link rel="stylesheet" type="text/css" href="../RESOURCES/CSS/scan_barcode.css">

    <style>
        body .time {
            font-weight: bold;
            text-align: center;
            margin-top: 3%;
            font-size: 70px;
            color: green;
            font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
            text-transform: uppercase;
        }

        .button {
            background-color: #5E7C2A;
            border: none;
            color: white;
            padding: 15px 150px;
            text-align: center;
            margin-left: 32%;
            text-decoration: none;
            display: inline-block;
            font-size: 28px;
            cursor: pointer;
            -webkit-transition-duration: 0.4s;
            transition-duration: 0.4s;
        }

        .label {
            justify-content: center;
        }

        .button:hover {
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .body {
            background-image: linear-gradient(rgba(0, 178, 10, 0.2), white);
            justify-content: center;
            padding-bottom: 10px;
        }

        .sjcbi {
            display: block;
            margin: 0 auto; 
            max-width: 17%; 
            height: auto; 
            margin-botton: 2px; 
        }
    </style>

    <script>
        function updateClock() {
            var date = new Date();
            var hour = date.getHours();
            var minute = date.getMinutes();
            var second = date.getSeconds();
            var period = hour >= 12 ? 'PM' : 'AM';
            hour = hour % 12;
            hour = hour ? hour : 12;
            var formattedTime = hour + ':' + (minute < 10 ? '0' : '') + minute + ':' + (second < 10 ? '0' : '') + second + ' ' + period;
            document.getElementById('date').innerHTML = '<?= $currentDate ?>' + '/' + '<?= $dayOfWeek ?>';
            document.getElementById('clock').innerHTML = formattedTime;
        }

        setInterval(updateClock, 1000); // Update every second
    </script>
</head>
<body class="body">
    <img src="..\RESOURCES\IMAGES\logo.png" class="sjcbi">
    <div class="time">
        <?php
        echo date('l Y/m/d');
        ?>
        <body onload="startTime()">
            <div id="txt"></div>

            <script>
                function startTime() {
                    const today = new Date();
                    let h = today.getHours();
                    let m = today.getMinutes();
                    let s = today.getSeconds();
                    let ampm = h >= 12 ? 'PM' : 'AM';

                    // Convert to 12-hour format
                    h = h % 12;
                    h = h ? h : 12; // 0 should be displayed as 12

                    m = checkTime(m);
                    s = checkTime(s);

                    document.getElementById('txt').innerHTML = h + ":" + m + ":" + s + " " + ampm;
                    setTimeout(startTime, 1000);
                }

                function checkTime(i) {
                    if (i < 10) {
                        i = "0" + i;
                    } // add zero in front of numbers < 10
                    return i;
                }
            </script>
    </div>

    <div class="container">
        <form action="scan_process.php" method="post">
            <label for="barcode">Scan:</label>
            <input type="text" id="barcode" name="barcode" required><br><br>
            <script>
                document.getElementById('barcode').addEventListener('input', function (event) {
                    // Check if the length of the input is equal to the expected barcode length
                    if (event.target.value.length === 12) {
                        // Automatically submit the form
                        document.getElementById('barcodeForm').submit();
                        // Clear the input field after submission
                        event.target.value = '';
                    }
                });

                // Automatically focus on the input field when the page loads
                window.onload = function () {
                    document.getElementById('barcode').focus();
                };
            </script>
        </form>
    </div>
</body>
</html>
