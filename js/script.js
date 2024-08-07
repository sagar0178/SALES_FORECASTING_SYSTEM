$(document).ready(function () {
    // Sample data for charts
    var salesData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Sales',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)',
            hoverBorderColor: 'rgba(255, 99, 132, 1)',
            data: [65, 33, 43, 23, 45, 23, 59, 80, 81, 56, 55, 40],
        }]
    };

    var forecastData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Forecast',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            hoverBackgroundColor: 'rgba(54, 162, 235, 0.4)',
            hoverBorderColor: 'rgba(54, 162, 235, 1)',
            data: [28, 48, 77, 45, 44, 54, 94, 40, 19, 86, 27, 90],
        }]
    };

    var ctx = $("#salesChart");
    var salesChart = new Chart(ctx, {
        type: 'bar',
        data: salesData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx2 = $("#forecastChart");
    var forecastChart = new Chart(ctx2, {
        type: 'line',
        data: forecastData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Form Validation and AJAX Submission
    $("#productForm").on("submit", function (event) {
        event.preventDefault();

        var formData = {
            name: $("#productName").val(),
            description: $("#productDescription").val(),
            price: $("#productPrice").val(),
            stock: $("#productStock").val(),
            category: $("#productCategory").val()
        };

        $.ajax({
            type: "POST",
            url: "backend.php",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            console.log(data);
        });
    });
});