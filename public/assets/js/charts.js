export function initStockChart(transactions, forecastMonths = 6) {
  const monthName = (year, month) =>
    new Date(year, month).toLocaleString("default", { month: "long" });

  const addMonths = (startDate, count) => {
    const months = [];
    for (let i = 0; i < count; i++) {
      const d = new Date(startDate.getFullYear(), startDate.getMonth() + i);
      months.push(monthName(d.getFullYear(), d.getMonth()));
    }
    return months;
  };

  const incomingData = transactions.DataIn.map((d) => ({
    month: monthName(d.year, d.month - 1),
    qty: Number(d.total_quantity),
  }));
  const outgoingData = transactions.DataOut.map((d) => ({
    month: monthName(d.year, d.month - 1),
    qty: Number(d.total_quantity),
  }));

  let monthLabels = Array.from(
    new Set([...incomingData, ...outgoingData].map((d) => d.month))
  );

  const stockMap = {};
  monthLabels.forEach((m) => (stockMap[m] = { masuk: 0, keluar: 0 }));
  incomingData.forEach((d) => (stockMap[d.month].masuk = d.qty));
  outgoingData.forEach((d) => (stockMap[d.month].keluar = d.qty));

  const futureMonths = addMonths(new Date(), forecastMonths);
  futureMonths.forEach((m) => {
    if (!monthLabels.includes(m)) {
      monthLabels.push(m);
      stockMap[m] = { masuk: 0, keluar: 0 };
    }
  });

  const ctx = document.getElementById("stockChart").getContext("2d");

  // === Gradient warna ===
  const gradientIn = ctx.createLinearGradient(0, 0, 0, 400);
  gradientIn.addColorStop(0, "rgba(54, 162, 235, 0.6)"); // Biru solid
  gradientIn.addColorStop(1, "rgba(54, 162, 235, 0.05)"); // Transparan

  const gradientOut = ctx.createLinearGradient(0, 0, 0, 400);
  gradientOut.addColorStop(0, "rgba(255, 99, 132, 0.6)"); // Merah solid
  gradientOut.addColorStop(1, "rgba(255, 99, 132, 0.05)"); // Transparan

  const chartData = {
    labels: monthLabels,
    datasets: [
      {
        label: "Barang Masuk",
        data: monthLabels.map((m) => stockMap[m].masuk),
        backgroundColor: gradientIn,
        borderColor: "rgba(54, 162, 235, 1)",
        tension: 0.35,
        fill: true,
      },
      {
        label: "Barang Keluar",
        data: monthLabels.map((m) => stockMap[m].keluar),
        backgroundColor: gradientOut,
        borderColor: "rgba(255, 99, 132, 1)",
        tension: 0.35,
        fill: true,
      },
    ],
  };

  new Chart(ctx, {
    type: "line",
    data: chartData,
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: `Pergerakan Stok (${forecastMonths} Bulan Kedepan)`,
          color: "#374151",
          font: { size: 16 },
        },
        tooltip: {
          mode: "index",
          intersect: false,
          backgroundColor: "rgba(255,255,255,0.95)",
          titleColor: "#111",
          bodyColor: "#111",
          borderColor: "#ddd",
          borderWidth: 1,
        },
        legend: {
          position: "bottom",
          labels: {
            usePointStyle: true,
            generateLabels: (chart) => {
              const datasets = chart.data.datasets;
              return datasets.map((dataset, i) => {
                const meta = chart.getDatasetMeta(i);
                const hidden = meta.hidden; // cek status hidden

                return {
                  text: dataset.label,
                  fillStyle: hidden
                    ? "transparent" // lingkaran kosong saat nonaktif
                    : dataset.borderColor, // lingkaran penuh saat aktif
                  strokeStyle: dataset.borderColor,
                  lineWidth: 2,
                  pointStyle: "circle",
                  hidden: hidden,
                  datasetIndex: i,
                  fontColor: "#374151",
                };
              });
            },
          },
          onClick: (e, legendItem, legend) => {
            const index = legendItem.datasetIndex;
            const ci = legend.chart;
            const meta = ci.getDatasetMeta(index);

            // Toggle manual
            meta.hidden =
              meta.hidden === null ? !ci.data.datasets[index].hidden : null;

            ci.update();
          },
        },
      },
      scales: {
        x: {
          title: { display: true, text: "Bulan", color: "#374151" },
          grid: {
            color: document.documentElement.classList.contains("dark")
              ? "#374151" // Dark mode
              : "#f3f4f6", // Light mode
          },
          ticks: { color: "#374151" },
        },
        y: {
          beginAtZero: true,
          title: { display: true, text: "Jumlah", color: "#374151" },
          grid: {
            color: document.documentElement.classList.contains("dark")
              ? "#374151"
              : "#f3f4f6",
          },
          ticks: { color: "#374151" },
        },
      },
    },
  });
}
