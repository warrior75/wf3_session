	<nav class="navbar navbar-inverse">
		  <div class="container">
		    <div class="navbar-header">
		        <a class="navbar-brand" href="index.php">Session</a>
		    </div>

		      <ul class="nav navbar-nav">
		        <li class="<?php if($page == 'home') echo 'active'; ?>"><a href="home.php">Home</a></li>
		        <li class="<?php if($page == 'friend') echo 'active'; ?>" ><a href="friend.php">Friends</a></li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li class="<?php if($page == 'profile') echo 'active'; ?>"><a href="profile.php">Profile</a></li>
		        <li class="<?php if($page == 'logout') echo 'active'; ?>"><a href="logout.php">Logout</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>