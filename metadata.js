exports.handler = function(event, context, callback) {

  var response = {
    "instance-id": process.env.EC2_INSTANCE_ID,
    "availability-zone": process.env.EC2_AVAILABILITY_ZONE,
    "private-ip": process.env.EC2_PRIVATE_IP, 
    "public-ip": process.env.EC2_PUBLIC_IP
  };

  callback(null, response);

};