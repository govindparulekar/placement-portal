<?php
session_start();
if (isset($_session['logged_in']&&$_session['logged_id'] === true)) {
  header('Location:../pages/');
}
else{
  echo "hello";
}
 ?>
