/**
 * Modal Confirmation Functions
 * Untuk menampilkan peringatan delete dan logout
 */

// Function untuk menampilkan modal konfirmasi
function showConfirmationModal(
    title,
    message,
    confirmText = "Ya, Hapus",
    cancelText = "Batal",
    isDangerous = false,
) {
    const modal = document.getElementById("confirmationModal");
    const titleEl = document.getElementById("confirmationTitle");
    const messageEl = document.getElementById("confirmationMessage");
    const confirmBtn = document.getElementById("confirmationConfirmBtn");
    const cancelBtn = document.getElementById("confirmationCancelBtn");

    titleEl.textContent = title;
    messageEl.textContent = message;
    confirmBtn.textContent = confirmText;
    cancelBtn.textContent = cancelText;

    // Ubah warna button sesuai type aksi
    if (isDangerous) {
        confirmBtn.className = "btn btn-danger";
    } else {
        confirmBtn.className = "btn btn-primary";
    }

    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();

    return new Promise((resolve) => {
        confirmBtn.onclick = () => {
            bootstrapModal.hide();
            resolve(true);
        };
        cancelBtn.onclick = () => {
            bootstrapModal.hide();
            resolve(false);
        };
        modal.addEventListener(
            "hidden.bs.modal",
            () => {
                resolve(false);
            },
            { once: true },
        );
    });
}

// Function khusus untuk konfirmasi logout
async function confirmLogout(event) {
    event.preventDefault();

    const result = await showConfirmationModal(
        "Konfirmasi Logout",
        "Apakah Anda yakin ingin keluar dari aplikasi?",
        "Ya, Logout",
        "Batal",
        true,
    );

    if (result) {
        // Submit form yang mengandung tombol logout
        const form = event.target.closest("form");
        if (form) {
            form.submit();
        }
    }
}

// Function khusus untuk konfirmasi delete
async function confirmDelete(event, aspirationTitle = "aspirasi ini") {
    event.preventDefault();

    const result = await showConfirmationModal(
        "Konfirmasi Penghapusan",
        `Apakah Anda yakin ingin menghapus ${aspirationTitle}? Tindakan ini tidak dapat dibatalkan.`,
        "Ya, Hapus",
        "Batal",
        true,
    );

    if (result) {
        // Submit form yang mengandung tombol delete
        const form = event.target.closest("form");
        if (form) {
            form.submit();
        }
    }
}
