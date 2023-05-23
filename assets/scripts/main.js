$(function () {
  let $win = $(window);
  let $doc = $(document);
  let myChart;

  const createBinComponent = (binId, location, volume, status, lastUpdate) => {
    const binItem = $(".bin-item.template").clone();
    binItem.removeClass("template").addClass("base");
    binItem.find(".bin-title").text("Smart Bin ID# " + binId);

    const currentTimestamp = Math.floor(Date.now() / 1000);
    const isOnline = currentTimestamp - lastUpdate <= 5;

    const binStatus = binItem.find(".bin-status");
    binStatus.find("p").text(isOnline ? "ONLINE" : "OFFLINE");

    if (isOnline) {
      binStatus.addClass("online");
    } else {
      binStatus.addClass("offline");
    }

    binItem.attr("data-bin-id", binId);
    binItem.attr("data-state", isOnline ? "1" : "0");

    binItem
      .find('.bin-info span:contains("Location:")')
      .next()
      .find("span")
      .text(location);
    binItem
      .find('.bin-info span:contains("Volume (L):")')
      .next()
      .find("span")
      .text(volume);
    binItem.find('.bin-info span:contains("Status:")').next().text(status);
    const lastUpdateDate = new Date(lastUpdate * 1000);
    const formattedLastUpdate = lastUpdateDate.toLocaleString();
    binItem
      .find('.bin-info span:contains("Last Update:")')
      .next()
      .text(formattedLastUpdate);
    return binItem;
  };

  const refreshBinLogsInformation = () => {
    $.ajax({
      url: "assets/php/ajax/getBinLogs.php",
      type: "GET",
      dataType: "json",
      success: function (response) {
        initBinLogsChart(response);
      },
      error: function (xhr, status, error) {
        console.log("AJAX request error:", error);
      },
    });
  };

  const initBinLogsChart = (binLogsData) => {
    const chartElement = document.querySelector(".chart");

    // Extracting the timestamp and counting occurrences of FULL and EMPTY
    const binLogsByTimestamp = binLogsData.reduce((acc, log) => {
      const timestamp = new Date(log.logTimestamp * 1000);
      const hour = timestamp.getHours();
      const binStatus = log.binStatus == "NOT FULL" ? "EMPTY" : "FULL";

      const formattedTimestamp = `${timestamp.getDate()}/${
        timestamp.getMonth() + 1
      }/${timestamp.getFullYear()} ${hour}:00`;

      if (!acc[formattedTimestamp]) {
        acc[formattedTimestamp] = { FULL: 0, EMPTY: 0 };
      }

      acc[formattedTimestamp][binStatus] += 1;

      return acc;
    }, {});

    const timestamps = Object.keys(binLogsByTimestamp);
    const fullCounts = Object.values(binLogsByTimestamp).map(
      (data) => data.FULL
    );
    const emptyCounts = Object.values(binLogsByTimestamp).map(
      (data) => data.EMPTY
    );

    // Check if the chart has been initialized
    if (!myChart) {
      const config = {
        type: "bar",
        data: {
          labels: timestamps,
          datasets: [
            {
              label: "FULL",
              data: fullCounts,
              backgroundColor: "rgba(75, 192, 192, 0.5)",
              borderColor: "rgba(75, 192, 192, 1)",
              borderWidth: 1,
            },
            {
              label: "EMPTY",
              data: emptyCounts,
              backgroundColor: "rgba(255, 99, 132, 0.5)",
              borderColor: "rgba(255, 99, 132, 1)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: "Bin Status by Timestamp",
              color: "white",
            },
            tooltip: {
              backgroundColor: "rgba(0, 0, 0, 0.8)",
              titleColor: "white",
              bodyColor: "white",
              borderColor: "white",
            },
            legend: {
              labels: {
                color: "white",
              },
            },
          },
          scales: {
            x: {
              title: {
                display: true,
                text: "Timestamp",
                color: "white",
              },
              ticks: {
                color: "white",
                autoSkip: false,
                maxRotation: 0,
                minRotation: 0,
              },
            },
            y: {
              title: {
                display: true,
                text: "Count",
                color: "white",
              },
              ticks: {
                color: "white",
                precision: 0,
                beginAtZero: true,
              },
            },
          },
        },
      };

      myChart = new Chart(chartElement, config);
    } else {
      // Update the chart data without reinitializing
      myChart.data.labels = timestamps;
      myChart.data.datasets[0].data = fullCounts;
      myChart.data.datasets[1].data = emptyCounts;
      myChart.update(); // Update the chart with new data
    }
  };

  const refreshBinInformation = () => {
    $.ajax({
      url: "assets/php/ajax/getBins.php",
      type: "GET",
      dataType: "json",
      success: function (data) {
        $(".bins").find(".bin-item.base").remove();
        data.forEach(function (row) {
          const id = row.id;
          const binVolume = row.binVolume;
          const binLocation = row.binLocation;
          const binStatus = row.binStatus;
          const lastPing = row.lastPing;

          /*console.log("ID: " + id);
          console.log("Bin Volume: " + binVolume);
          console.log("Bin Location: " + binLocation);
          console.log("Bin Status: " + binStatus);
          console.log("Last Ping: " + lastPing);
          console.log("---------------------------");
          */

          $(".bins")
            .addClass("loaded")
            .append(
              createBinComponent(
                id,
                binLocation,
                binVolume,
                binStatus,
                lastPing
              )
            );
        });
      },
      error: function (xhr, status, error) {
        console.log("AJAX request error:", error);
      },
    });
  };

  $doc.on("click", ".js-edit-location", function () {
    var binItem = $(this).closest(".bin-item");
    var binId = binItem.data("bin-id");

    var userInput = prompt("Edit Bin Location:");

    if (userInput && userInput.trim() !== "" && userInput.length <= 25) {
      var command = "updateLocation " + userInput;
      sendUpdateRequest(binId, command);
    } else {
      alert("Invalid input for bin location.");
    }
  });

  $doc.on("click", ".js-edit-volume", function () {
    var binItem = $(this).closest(".bin-item");
    var binId = binItem.data("bin-id");

    var userInput = prompt("Edit Bin Volume (L):");

    if (userInput && !isNaN(userInput)) {
      var command = "updateVolume " + userInput;
      sendUpdateRequest(binId, command);
    } else {
      alert("Invalid input for bin volume. Please enter a number.");
    }
  });

  function sendUpdateRequest(binId, command) {
    $.ajax({
      type: "POST",
      url: "assets/php/ajax/updateBin.php",
      data: {
        binId: binId,
        command: command,
      },
      dataType: "json",
      success: function (response) {
        if (response.status) {
          alert("Bin update request was successful.");
          // Perform any additional actions or update the UI as needed
        } else {
          alert("Bin update request failed. " + response.message);
        }
      },
      error: function () {
        alert("An error occurred while sending the bin update request.");
      },
    });
  }

  setInterval(function () {
    refreshBinInformation();
    refreshBinLogsInformation();
  }, 1000);

  refreshBinInformation();
  refreshBinLogsInformation();
});
