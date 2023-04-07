<?php
function password_check($password_check_input) {
        // Encrypt your password and uppercase all chars
        $sha1_password = strtoupper(sha1($password_check_input));
        // Trim to the first 5 characters of the hash
        $sha1_password_short = substr($sha1_password, 0, 5);

        // Fetch hash list
        $curl = curl_init();

                curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.pwnedpasswords.com/range/$sha1_password_short",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                                "content-type: text/plain"
                        ),
                ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        // Put reponse into an array
        $lines = explode(PHP_EOL, $response);

        // Set hitcounter to ZERO
        $hitcounter=0;

        // Loop through all lines
        foreach ($lines as $line => $row) {
                // Join the 5 sha1 chars with the result
                $row = $sha1_password_short . $row;
                // Break output
                $row = explode(':', $row);
                // Set hash as row (part zero of the explode)
                $row = $row[0];

                // Check if the hash matches your encrypted password
                if ($row == $sha1_password) {
                        $hitcounter++;
                }
        }

        curl_close($curl);

        if ($err) {
                echo "cURL Error: $err";
        }

        if ($hitcounter != 0) {
                echo "<p><center>The chosen password is known as a breached password!<br>
                Please select a different password</center></p>";
                die;
        }
}

password_check("MySsecretPassword");
?>