<!DOCTYPE html>
<html>
<head>
    <title>EC2 Instance Metadata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>EC2 Instance Metadata</h1>
    <?php
    require_once 'metadata.php';

    echo '<h2>Instance Metadata</h2>';
    echo '<ul>';
    echo '<li><strong>Instance ID:</strong> ' . getMetadata('/instance-id') . '</li>';
    echo '<li><strong>Instance Type:</strong> ' . getMetadata('/instance-type') . '</li>';
    echo '<li><strong>Public IP:</strong> ' . getMetadata('/public-ipv4') . '</li>';
    echo '<li><strong>Private IP:</strong> ' . getMetadata('/local-ipv4') . '</li>';
    echo '<li><strong>Availability Zone:</strong> ' . getMetadata('/placement/availability-zone') . '</li>';
    echo '<li><strong>Instance AMI ID:</strong> ' . getMetadata('/ami-id') . '</li>';
    echo '</ul>';

    echo '<h2>Network Interfaces</h2>';
    $networkInterfaces = getMetadata('/network/interfaces/macs/');
    if (!empty($networkInterfaces)) {
        echo '<ul>';
        foreach ($networkInterfaces as $mac => $interface) {
            echo '<li><strong>MAC Address:</strong> ' . $mac . '</li>';
            echo '<ul>';
            echo '<li><strong>Interface ID:</strong> ' . $interface['interface-id'] . '</li>';
            echo '<li><strong>Subnet ID:</strong> ' . $interface['subnet-id'] . '</li>';
            echo '<li><strong>VPC ID:</strong> ' . $interface['vpc-id'] . '</li>';
            echo '<li><strong>Private IP:</strong> ' . $interface['local-ipv4s'][0] . '</li>';
            echo '<li><strong>Public IP:</strong> ' . (isset($interface['public-ipv4s'][0]) ? $interface['public-ipv4s'][0] : 'N/A') . '</li>';
            echo '</ul>';
        }
        echo '</ul>';
    } else {
        echo '<p>No network interfaces found.</p>';
    }
    ?>
</body>
</html>
