// PendakwahModel.js

const mysql = require('mysql');
const dbConfig = require('../config.php'); // Assuming your database config is in config.php

const connection = mysql.createConnection(dbConfig);

class PendakwahModel {
    registerPendakwah(namaLengkap, email, password, dokumenPath) {
        return new Promise((resolve, reject) => {
            // Insert the user into the database
            const query = `INSERT INTO pendakwah (nama_lengkap, email, password, dokumen) VALUES (?, ?, ?, ?)`;
            connection.query(query, [namaLengkap, email, password, dokumenPath], (err, result) => {
                if (err) {
                    reject("Gagal registrasi pendakwah: " + err.message);
                } else {
                    resolve(true);
                }
            });
        });
    }
}

module.exports = PendakwahModel;
