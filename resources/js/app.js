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

// home page
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

//chart
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".sparkline-chart").forEach((el) => {
        const data = JSON.parse(el.dataset.prices || "[]");
        if (!Array.isArray(data) || data.length < 2) return;

        let trend = el.dataset.trend;

        // AUTO trend (market-compare)
        if (trend === "auto") {
            const len = data.length;
            const prev = Number(data[len - 2].y);
            const last = Number(data[len - 1].y);

            if (last > prev) trend = "up";
            else if (last < prev) trend = "down";
            else trend = "flat";
        }

        let color = "#9ca3af";
        if (trend === "up") color = "#ef4444";
        else if (trend === "down") color = "#22c55e";

        new ApexCharts(el, {
            chart: {
                type: "area",
                height: 70,
                sparkline: { enabled: true },
            },
            stroke: { curve: "smooth", width: 2 },
            fill: {
                type: "gradient",
                gradient: { opacityFrom: 0.35, opacityTo: 0.05 },
            },
            series: [{ name: "Harga", data }],
            xaxis: { type: "datetime" },
            colors: [color],
            tooltip: {
                x: { format: "dd MMMM yyyy" },
                y: {
                    formatter: (v) => "Rp " + Number(v).toLocaleString("id-ID"),
                },
            },
        }).render();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".commodity-filter").forEach((wrapper) => {
        const categorySelect = wrapper.querySelector(".category-select");
        const commoditySelect = wrapper.querySelector(".commodity-select");

        const allOptions = Array.from(commoditySelect.options);

        categorySelect.addEventListener("change", function () {
            const selectedCategory = String(this.value);

            commoditySelect.innerHTML = "";
            commoditySelect.appendChild(allOptions[0]); // Semua Komoditas

            allOptions.slice(1).forEach((option) => {
                if (
                    selectedCategory === "" ||
                    String(option.dataset.category) === selectedCategory
                ) {
                    commoditySelect.appendChild(option);
                }
            });
        });
        if (categorySelect.value !== "") {
            categorySelect.dispatchEvent(new Event("change"));
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const commoditySelect = document.querySelector(".commodity-select");
    const allMarketOption = document.getElementById("allMarketOption");
    const marketSelect = document.getElementById("marketSelect");

    function toggleAllMarket() {
        const hasCommodity = commoditySelect.value !== "";

        // tampilkan SEMUA PASAR hanya jika komoditas dipilih
        allMarketOption.hidden = !hasCommodity;

        // jika komoditas dikosongkan & posisi di ALL → reset ke AVG
        if (!hasCommodity && marketSelect.value === "all") {
            marketSelect.value = "avg";
        }
    }

    commoditySelect.addEventListener("change", toggleAllMarket);
    toggleAllMarket(); // init
});

document.addEventListener("DOMContentLoaded", function () {
    const root = document.getElementById("comparison-root");
    if (!root) return;

    const BASE_URL = root.dataset.url;

    // Checkbox limit (max 5)
    const checkboxes = document.querySelectorAll(".comparison-market-checkbox");
    const maxMarkets = 5;

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            const checkedCount = document.querySelectorAll(
                ".comparison-market-checkbox:checked"
            ).length;

            if (checkedCount >= maxMarkets) {
                checkboxes.forEach((cb) => {
                    if (!cb.checked) cb.disabled = true;
                });
            } else {
                checkboxes.forEach((cb) => (cb.disabled = false));
            }
        });
    });

    // Date validation (from <= to)
    const dateFrom = document.getElementById("comp_date_from");
    const dateTo = document.getElementById("comp_date_to");

    dateFrom.addEventListener("change", function () {
        if (this.value > dateTo.value) {
            dateTo.value = this.value;
        }
    });

    dateTo.addEventListener("change", function () {
        if (this.value < dateFrom.value) {
            dateFrom.value = this.value;
        }
    });

    // Button Compare Click
    const btnCompare = document.getElementById("btn-compare");
    const compCommodity = document.getElementById("comp_commodity");

    const initialState = document.getElementById("comparison-initial");
    const loadingState = document.getElementById("comparison-loading");
    const resultState = document.getElementById("comparison-result");

    let comparisonChartInstance = null;

    btnCompare.addEventListener("click", function () {
        const commodityId = compCommodity.value;
        const selectedMarkets = Array.from(
            document.querySelectorAll(".comparison-market-checkbox:checked")
        );

        // Validation
        if (!commodityId) {
            alert("Pilih komoditas terlebih dahulu!");
            return;
        }

        if (selectedMarkets.length < 2) {
            alert("Pilih minimal 2 pasar untuk dibandingkan!");
            return;
        }

        const marketIds = selectedMarkets.map((m) => m.value);
        const from = dateFrom.value;
        const to = dateTo.value;

        console.log("Market IDs:", marketIds);
        console.log("Commodity ID:", commodityId);

        // Show loading & hide others
        initialState.classList.add("hidden");
        resultState.classList.add("hidden");
        loadingState.classList.remove("hidden");

        // Fetch data
        const url = `${BASE_URL}?commodity_id=${commodityId}&market_ids[]=${marketIds.join(
            "&market_ids[]="
        )}&date_from=${from}&date_to=${to}`;

        console.log("Fetching:", url);

        fetch(url)
            .then((res) => {
                console.log("Response status:", res.status);
                if (!res.ok) {
                    throw new Error(`HTTP ${res.status}`);
                }
                return res.json();
            })
            .then((data) => {
                console.log("Data received:", data);

                if (!data.success) {
                    throw new Error(data.error || "Unknown error");
                }

                loadingState.classList.add("hidden");
                initialState.classList.add("hidden");
                resultState.classList.remove("hidden");

                renderComparison(data);

                // Re-render Lucide icons after DOM update
                setTimeout(() => {
                    lucide.createIcons();
                }, 100);
            })
            .catch((err) => {
                console.error("Error:", err);
                loadingState.classList.add("hidden");
                resultState.classList.add("hidden");
                initialState.classList.remove("hidden");
                alert("Gagal memuat data: " + err.message);
            });
    });

    function renderComparison(data) {
        console.log("Rendering comparison...");

        // Update title
        document.getElementById(
            "comparison-title"
        ).textContent = `Statistik Perbandingan Harga ${data.commodity_name}, ${data.unit}`;

        document.getElementById(
            "comparison-date-range"
        ).textContent = `${formatDate(data.date_from)} - ${formatDate(
            data.date_to
        )}`;

        const markets = data.markets;
        console.log("Markets data:", markets);

        if (!markets || markets.length === 0) {
            alert("Tidak ada data untuk ditampilkan");
            return;
        }

        // Calculate min/max
        const allPrices = markets
            .map((m) => m.latest_price)
            .filter((p) => p !== null && p > 0);

        if (allPrices.length === 0) {
            alert("Tidak ada data harga untuk periode ini");
            return;
        }

        const minPrice = Math.min(...allPrices);
        const maxPrice = Math.max(...allPrices);

        const minMarket = markets.find((m) => m.latest_price === minPrice);
        const maxMarket = markets.find((m) => m.latest_price === maxPrice);

        console.log("Min price:", minPrice, "Max price:", maxPrice);

        // Update statistics
        document.getElementById(
            "stat-min-price"
        ).textContent = `Rp ${minPrice.toLocaleString("id-ID")}`;

        document.getElementById("stat-min-market").textContent =
            minMarket.market_name;

        document.getElementById(
            "stat-max-price"
        ).textContent = `Rp ${maxPrice.toLocaleString("id-ID")}`;
        document.getElementById("stat-max-market").textContent =
            maxMarket.market_name;

        const priceDiff = maxPrice - minPrice;
        const percentDiff = ((priceDiff / minPrice) * 100).toFixed(1);
        document.getElementById(
            "stat-diff-price"
        ).textContent = `Rp ${priceDiff.toLocaleString("id-ID")}`;
        document.getElementById(
            "stat-diff-percent"
        ).textContent = `${percentDiff}% dari harga termurah`;

        // Render chart
        renderChart(markets);
    }

    function renderChart(markets) {
        console.log("Rendering chart with markets:", markets);

        const series = markets.map((market) => {
            console.log(`${market.market_name} chart data:`, market.chart_data);
            return {
                name: market.market_name,
                data: market.chart_data || [],
            };
        });

        console.log("Chart series:", series);

        const options = {
            chart: {
                type: "area",
                height: 400,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        zoom: true,
                        pan: false,
                    },
                },
                zoom: {
                    enabled: true,
                },
                animations: {
                    enabled: true,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
                width: 3,
            },
            fill: {
                type: "gradient",
                gradient: {
                    opacityFrom: 0.6,
                    opacityTo: 0.1,
                },
            },
            series: series,
            xaxis: {
                type: "datetime",
                labels: {
                    format: "dd MMM",
                    style: {
                        fontSize: "12px",
                    },
                },
            },
            yaxis: {
                labels: {
                    formatter: (val) =>
                        "Rp " + Math.round(val).toLocaleString("id-ID"),
                    style: {
                        fontSize: "12px",
                    },
                },
            },
            tooltip: {
                x: {
                    format: "dd MMMM yyyy",
                },
                y: {
                    formatter: (val) =>
                        "Rp " + Math.round(val).toLocaleString("id-ID"),
                },
            },
            colors: ["#3B82F6", "#F59E0B", "#10B981", "#EF4444", "#8B5CF6"],
            legend: {
                position: "bottom",
                horizontalAlign: "center",
                fontSize: "14px",
                markers: {
                    width: 12,
                    height: 12,
                    radius: 12,
                },
            },
            grid: {
                borderColor: "#e5e7eb",
                strokeDashArray: 4,
            },
        };

        // Destroy previous chart if exists
        if (comparisonChartInstance) {
            console.log("Destroying previous chart...");
            comparisonChartInstance.destroy();
        }

        const chartElement = document.querySelector("#comparison-chart");
        console.log("Chart element:", chartElement);

        if (!chartElement) {
            console.error("Chart element not found!");
            return;
        }

        comparisonChartInstance = new ApexCharts(chartElement, options);

        console.log("Rendering chart...");
        comparisonChartInstance
            .render()
            .then(() => {
                console.log("Chart rendered successfully!");
            })
            .catch((err) => {
                console.error("Chart render error:", err);
            });
    }

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        const months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    }
});
