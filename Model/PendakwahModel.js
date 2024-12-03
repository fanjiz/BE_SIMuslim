const registerPendakwah = async (namaLengkap, email, password, dokumen) => {
  const formData = new FormData();
  formData.append("nama-lengkap", namaLengkap);
  formData.append("email", email);
  formData.append("password", password);
  formData.append("dokumen", dokumen);

  try {
    const response = await fetch("../controller/PendakwahController.php?action=register", {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (response.ok) {
      alert("Registrasi berhasil!");
    } else {
      alert("Terjadi kesalahan: " + data.error);
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Terjadi kesalahan dalam mengirim data");
  }
};
