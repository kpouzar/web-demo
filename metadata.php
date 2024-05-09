<?php
function getMetadata($path)
{
    $token = getToken();
    $url = "http://169.254.169.254/latest/dynamic/instance-metadata/$path";
    $headers = array(
        "X-aws-ec2-metadata-token: $token",
        "Accept: application/json"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode == 200) {
        if (strpos($response, 'mac') !== false) {
            $interfaces = json_decode($response, true);
            return $interfaces;
        } else {
            return $response;
        }
    } else {
        return "Error: " . $httpCode;
    }

    curl_close($ch);
}

function getToken()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://169.254.169.254/latest/api/token");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-aws-ec2-metadata-token-ttl-seconds: 21600"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode == 200) {
        return $response;
    } else {
        return "Error: " . $httpCode;
    }

    curl_close($ch);
}