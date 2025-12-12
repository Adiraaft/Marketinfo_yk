import "./bootstrap";
import { createIcons, icons } from "lucide";
import Swal from "sweetalert2";
window.Swal = Swal;

import Swiper from "swiper";
import "swiper/css";

import ApexCharts from "apexcharts";
window.ApexCharts = ApexCharts;

import { Navigation, Autoplay } from "swiper/modules";
import "swiper/css/navigation";

createIcons({ icons });

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

    document.addEventListener("click", (e) => {
        if (
            notifIcon &&
            notifModal &&
            !notifIcon.contains(e.target) &&
            !notifModal.contains(e.target)
        ) {
            notifModal.classList.add("hidden");
        }
        if (
            userIcon &&
            userModal &&
            !userIcon.contains(e.target) &&
            !userModal.contains(e.target)
        ) {
            userModal.classList.add("hidden");
        }
    });

    // --------------------------------------
    // 🚀 INISIALISASI SWIPER (Slider Otomatis)
    // --------------------------------------
    if (document.querySelector(".mySwiper")) {
        new Swiper(".mySwiper", {
            modules: [Navigation, Autoplay],
            loop: true,
            autoplay: {
                delay: 3000,
            },
            speed: 800,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    }
});
