const form = document.querySelector('form');
form.addEventListener('submit', async (e) => {
  e.preventDefault();

  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  const response = await fetch('UserController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      register: true,
      username: username,
      email: email,
      password: password
    })
  });

  const result = await response.json();
  if (result.success) {
    alert('Registrasi berhasil!');
    window.location.href = 'login_user.php';
  } else {
    alert('Registrasi gagal: ' + result.message);
  }
});
