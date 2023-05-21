<?php
// Define the checkAvailability function here

function checkAvailability($roomId, $date) {
  // Your implementation logic
}

// Retrieve room data from your database
// Example: Replace the following line with your database query
$rooms = [
    ['room_id' => 1, 'room_name' => 'Room 1'],
    ['room_id' => 2, 'room_name' => 'Room 2'],
    // Add more room data as needed
];

// Define an array of dates or retrieve it from your database
// Example: Replace the following line with your actual code to define the dates array
$dates = ['2023-06-01', '2023-06-02', '2023-06-03', '2023-06-04', '2023-06-05'];

?>

<!-- Begin HTML markup -->
<table>
  <tr>
    <th>Room</th>
    <th>Date</th>
    <th>Availability</th>
  </tr>
  <?php
    // Loop through rooms and dates to populate the table
    foreach ($rooms as $room) {
      foreach ($dates as $date) {
        echo "<tr>";
        echo "<td>{$room['room_name']}</td>";
        echo "<td>{$date}</td>";
        echo "<td>";
        
        // Check availability based on bookings data
        $isAvailable = checkAvailability($room['room_id'], $date);
        
        if ($isAvailable) {
          echo "Available";
        } else {
          echo "Booked";
        }
        
        echo "</td>";
        echo "</tr>";
      }
    }
  ?>
</table>
<!-- End HTML markup -->
