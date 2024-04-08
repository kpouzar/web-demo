// Function to fetch metadata from IMDS v2
async function fetchMetadata(path) {
  const token = await fetchToken();
  const response = await fetch(`http://169.254.169.254/latest/dynamic/instance-identity/document${path}`, {
      headers: {
          'X-aws-ec2-metadata-token': token
      }
  });
  return await response.json();
}

// Function to fetch token from IMDS v2
async function fetchToken() {
  const response = await fetch('http://169.254.169.254/latest/api/token', {
      headers: {
          'X-aws-ec2-metadata-token-ttl-seconds': '21600'
      }
  });
  return await response.text();
}

// Function to display metadata in the table
async function displayMetadata() {
  const metadataKeys = ['instanceId', 'availabilityZone', 'privateIpAddress', 'publicIpAddress'];
  const tableBody = document.querySelector('#metadata-table tbody');

  for (const key of metadataKeys) {
      const value = await fetchMetadata(`/${key}`);
      const row = document.createElement('tr');
      row.innerHTML = `
          <td>${key}</td>
          <td>${value}</td>
      `;
      tableBody.appendChild(row);
  }
}

// Call the displayMetadata function when the page loads
window.onload = displayMetadata;