import "./bootstrap";
import { createIcons, icons } from "lucide";

createIcons({ icons });
// Inisialisasi ikon Lucide
document.addEventListener("DOMContentLoaded", () => {

    // --- Modal Navbar Dashboard ---
    const notifIcon = document.getElementById("notifIcon");
    const userIcon = document.getElementById("userIcon");
    const notifModal = document.getElementById("notifModal");
    const userModal = document.getElementById("userModal");

    if (notifIcon && notifModal) {
        notifIcon.addEventListener("click", () => {
            notifModal.classList.toggle("hidden");
            if (userModal) userModal.classList.add("hidden");
        });
    }

    if (userIcon && userModal) {
        userIcon.addEventListener("click", () => {
            userModal.classList.toggle("hidden");
            if (notifModal) notifModal.classList.add("hidden");
        });
    }

    // Tutup modal ketika klik di luar
    document.addEventListener("click", (e) => {
        if (notifIcon && notifModal && !notifIcon.contains(e.target) && !notifModal.contains(e.target)) {
            notifModal.classList.add("hidden");
        }
        if (userIcon && userModal && !userIcon.contains(e.target) && !userModal.contains(e.target)) {
            userModal.classList.add("hidden");
        }
    });
});

