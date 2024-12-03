const mysql = require('mysql');
const bcrypt = require('bcrypt'); // Untuk hashing password

// Koneksi database
const db = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "simuslim"
});

db.connect((err) => {
  if (err) throw err;
  console.log("Connected to the database");
});

// Fungsi registrasi pengguna
const registerUser = (username, email, password, role, callback) => {
  const hashedPassword = bcrypt.hashSync(password, 10); // Hash password

  const query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
  db.query(query, [username, email, hashedPassword, role], (err, result) => {
    if (err) {
      console.error("Error during registration: ", err);
      return callback(err);
    }
    callback(null, result);
  });
};

// Fungsi login pengguna
const loginUser = (usernameOrEmail, password, callback) => {
  const query = "SELECT id, username, password, role FROM users WHERE username = ? OR email = ?";
  db.query(query, [usernameOrEmail, usernameOrEmail], (err, results) => {
    if (err) {
      console.error("Error during login: ", err);
      return callback(err);
    }

    if (results.length === 0) {
      return callback(null, null); // Pengguna tidak ditemukan
    }

    // Verifikasi password
    const user = results[0];
    const isPasswordValid = bcrypt.compareSync(password, user.password);
    if (isPasswordValid) {
      return callback(null, user); // Login berhasil
    } else {
      return callback(null, null); // Password salah
    }
  });
};

module.exports = {
  registerUser,
  loginUser
};
