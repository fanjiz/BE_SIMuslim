// UserModel.js

// Function to handle user login
function login(username, password) {
    const loginData = {
      username: username,
      password: password
    };
  
    fetch('../api/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(loginData)  // Send login data as JSON
    })
    .then(response => response.json())  // Parse the JSON response
    .then(data => {
      if (data.success) {
        // Redirect the user to the homepage if login is successful
        window.location.href = '../view/HOMEPAGE/HOMEPENDAKWAH.html';
      } else {
        // Display error message if login fails
        alert('Username or Password is incorrect!');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }
  