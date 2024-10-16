<?php
// URL for the Instance Metadata Service
$imds_url = 'http://169.254.169.254/latest/dynamic/instance-identity/document';
$imds_token_url = 'http://169.254.169.254/latest/api/token';
$public_ip_url = 'http://169.254.169.254/latest/meta-data/public-ipv4'; 

// Get the IMDS token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $imds_token_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-aws-ec2-metadata-token-ttl-seconds: 60']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$token = curl_exec($ch);
curl_close($ch);

// Set cURL options
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $imds_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-aws-ec2-metadata-token: ' . $token]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
 
// Create a new cURL resource
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $imds_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$metadata = curl_exec($ch);

// Check for errors
if ($metadata === false) {
    echo 'cURL error: ' . curl_error($ch);
    } else {
// Decode the JSON response
$metadata = json_decode($metadata, true);
            }

// Close the cURL resource
curl_close($ch);

// Set cURL options to fetch public IP address
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $public_ip_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-aws-ec2-metadata-token: ' . $token]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$public_ip = curl_exec($ch);

// Check for errors
if ($public_ip === false) {
    echo 'cURL error: ' . curl_error($ch);
    }

// Close the cURL resource
curl_close($ch); 



// Filter the desired metadata keys
$desired_keys = [
   'region' => $metadata['region'],
   'availabilityZone' => $metadata['availabilityZone'],
   'privateIpAddress' => $metadata['privateIp'],
   'publicIpAddress' => $public_ip,
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EC2 Instance Metadata</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<img src="1-Header.png" class="center">   
<!-- <img src="pic-alef.png" width="20%"> -->
  <h1>Welcome our ALEF DEMO in AWS!</h1>
 
  <table>
     <tr>
        <th>Key</th>
        <th>Value</th>
     </tr>
     <?php foreach ($desired_keys as $key => $value): ?>
        <tr>
           <td><?php echo $key; ?></td>
           <td><?php echo is_array($value) ? print_r($value, true) : $value; ?></td>
        </tr>
     <?php endforeach; ?>
  </table>
 
<img src="2-Footer.png">   
</body>
</html>
