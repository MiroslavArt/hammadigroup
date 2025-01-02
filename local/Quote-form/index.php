<?php
$ID = $_GET['id'];  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote Approval Form</title>
    <style>
        /* General form container styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Added max width for better responsiveness */
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }

        /* Phone label and input on the same row */
        .phone-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: inline-block;
            text-align: left;
        }

        /* Phone input field styling */
        input[type="tel"] {
            width: calc(100% - 80px); /* Adjust to fit label and input on the same row */
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Button styles */
        .form-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 48%;
            transition: background-color 0.3s ease;
        }

        /* Approve button styles */
        .approve-btn {
            background-color: #28a745;
            color: white;
        }

        .approve-btn:hover {
            background-color: #218838;
        }

        /* Reject button styles */
        .reject-btn {
            background-color: #dc3545;
            color: white;
        }

        .reject-btn:hover {
            background-color: #c82333;
        }

        /* Button disabled state */
        button:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        /* Quote Approval label takes up 100% width */
        .quote-label {
            width: 100%;
            text-align: left;
            margin-top: 20px;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            .form-container {
                width: 90%;
                padding: 15px;
            }

            button {
                width: 100%; /* Stack buttons on small screens */
                margin-bottom: 10px;
            }

            input[type="tel"] {
                width: 100%; /* Make the phone input full width on small screens */
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Quote Approval Form</h2>
        <form id="quote-form">
            <!-- Phone input section in the same row -->
            <div class="phone-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
            </div>

            <!-- Quote Approval label that takes up 100% width -->
            <div class="quote-label">
                <label>Quote Approval:</label>
            </div>

            <!-- Approve and Reject buttons -->
            <div class="form-buttons">
                <button type="button" class="approve-btn" id="approve-btn">Approve</button>
                <button type="button" class="reject-btn" id="reject-btn">Reject</button>
            </div>
        </form>
    </div>

    <script>
        // Handle the approval button click
        document.getElementById('approve-btn').addEventListener('click', function() {
            updateDeal(136); // Approve action with value 136
        });

        // Handle the reject button click
        document.getElementById('reject-btn').addEventListener('click', function() {
            updateDeal(137); // Reject action with value 137
        });

        // Function to update the deal using Bitrix24 API
        function updateDeal(statusValue) {
            const dealId = <?php echo $ID; ?>; // Get the deal ID from PHP
            const apiUrl = `https://crm.hammadigroup.com/rest/1/57ubsh6qngsxzlmm/crm.deal.update.json?id=${dealId}`;
            
            // Prepare the data for updating the deal
            const data = JSON.stringify({
                "fields": {
                    "UF_CRM_1729078851484": statusValue // Update custom field value (Approve or Reject)
                }
            });

            // Make the API request to update the deal
            fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: data
            })
            .then(response => response.json())
            .then(data => {
                // Redirect to Thank You page after successful update
                window.location.href = 'https://crm.hammadigroup.com/local/Quote-form/thankyou.html';
            })
            .catch(error => {
                console.error('Error updating deal:', error);
            });
        }
    </script>
</body>
</html>
