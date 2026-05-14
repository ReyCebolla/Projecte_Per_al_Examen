<?php

function loginForm(){
	echo'
	<div id="loginform">
	<form action="index.php" method="post">
		<p><strong>Introdueix usuari i contrassenya per continuar:</strong></p>
		<label for="name">User: </label>
		<input type="text" name="user" id="name" /> 
                <label for="name">Pass: </label>
                <input type="text" name="pass" id="pass" /> 
		<input type="button" name="enter" id="enter" value="Enter" />
	</form>
	</div>
	';
}
