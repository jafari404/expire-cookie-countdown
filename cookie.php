<?php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$csrf_token = $_SESSION['csrf_token'];
$cookie_name = "SCRFSESSID";
$cookie_value = $csrf_token;
$cookie_expire = time() + 10;
setcookie($cookie_name, $cookie_value, $cookie_expire, "/");
// Check if the username cookie is set
$remaining_time = $cookie_expire - time();
?>
<div id="timer"></div>
  <script>
      // Set the expiration time of the cookie in seconds
      let expirationTime = <?php echo $remaining_time; ?>

      // Function to countdown and display the remaining time
      function displayCountdownTime() {
          let minutes = Math.floor(expirationTime / 60);
          let seconds = expirationTime % 60;

          // Display the remaining time in minutes and seconds
          document.getElementById('timer').innerHTML =  minutes +':'+ seconds ;
          if (expirationTime > 0) {
              expirationTime--;
              setTimeout(displayCountdownTime, 1000); // Update every second
          } else {
              document.getElementById('timer').innerHTML =  'Session Expired';
              Swal.fire({
                icon: "error",
                title: 'Session Expired. Login again.<?php
                  unset($_COOKIE['user_login']);
                  session_unset();
                  session_destroy(); ?>',
              }).then(function() {
              // Redirect the user
                window.location.href = "<?php echo $logout ?>";
              });
          }
      }

      // Call the function to start the countdown
      displayCountdownTime();
  </script>
