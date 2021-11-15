<?
// php var_dump($_SESSION); 
?>
<h2>BugMe Issue Tracker Login Form</h2>

<button id="login" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

<div id="id01" class="modal">
  
  <form class="modal-content animate" method="post">
    <div class="imgcontainer">
      <span id="x" class="close" onclick="document.getElementById('id01').style.display='none'" title="Close Login">&times;</span>
      <img src="images/female_avatar_icon.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
        <div class="form-fields">
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="user@email.com" name="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>
        </div>
        
      <button id="login-btn" type="submit">Login</button>
      <!-- <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label> -->
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <!-- <span class="psw"><a href="#">Forgot password?</a></span> -->
    </div>
  </form>
</div>
