import "./bootstrap";

import { createIcons, icons } from "lucide";
import Swal from "sweetalert2";
window.Swal = Swal;

createIcons({ icons });

// script modal navbar dashboard
document.addEventListener("DOMContentLoaded", () => {
    const notifIcon = document.getElementById("notifIcon");
    const userIcon = document.getElementById("userIcon");
    const notifModal = document.getElementById("notifModal");
    const userModal = document.getElementById("userModal");

    notifIcon.addEventListener("click", () => {
        notifModal.classList.toggle("hidden");
        userModal.classList.add("hidden"); // Tutup modal user jika notif dibuka
    });

    userIcon.addEventListener("click", () => {
        userModal.classList.toggle("hidden");
        notifModal.classList.add("hidden"); // Tutup modal notif jika user dibuka
    });

    // Klik di luar modal untuk menutup
    document.addEventListener("click", (e) => {
        if (!notifIcon.contains(e.target) && !notifModal.contains(e.target)) {
            notifModal.classList.add("hidden");
        }
        if (!userIcon.contains(e.target) && !userModal.contains(e.target)) {
            userModal.classList.add("hidden");
        }
    });
});
