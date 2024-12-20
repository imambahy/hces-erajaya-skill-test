<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        h1 {
            margin-bottom: 20px;
        }

        #employeeChart {
            max-width: 500px;
            max-height: 500px;
            width: 100%;
            height: auto;
        }

        button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        select {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>Employee Dashboard</h1>

    <div>
        <label for="company">Company:</label>
        <select id="company">
            <option value="">All</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
        </select>

        <label for="division">Division:</label>
        <select id="division">
            <option value="">All</option>
            @foreach ($divisions as $division)
                <option value="{{ $division->id }}">{{ $division->division_name }}</option>
            @endforeach
        </select>

        <label for="level">Level:</label>
        <select id="level">
            <option value="">All</option>
            @foreach ($levels as $level)
                <option value="{{ $level->id }}">{{ $level->level_name }}</option>
            @endforeach
        </select>

        <label for="gender">Gender:</label>
        <select id="gender">
            <option value="">All</option>
            @foreach ($genders as $gender)
                <option value="{{ $gender->id }}">{{ $gender->gender_name }}</option>
            @endforeach
        </select>

        <button id="filter">Filter</button>
    </div>

    <canvas id="employeeChart"></canvas>

    <script>
        const ctx = document.getElementById('employeeChart').getContext('2d');
        let chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Employees',
                    data: [],
                    backgroundColor: [],
                    borderColor: [],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Period (Month Year)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Employees'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        function formatPeriod(period) {
            const year = period.substring(0, 4);
            const month = period.substring(4, 6);
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            return `${monthNames[parseInt(month) - 1]} ${year}`;
        }

        function generateColors(count) {
            const colors = [];
            for (let i = 0; i < count; i++) {
                const r = Math.floor(Math.random() * 255);
                const g = Math.floor(Math.random() * 255);
                const b = Math.floor(Math.random() * 255);
                colors.push(`rgba(${r}, ${g}, ${b}, 0.5)`);
            }
            return colors;
        }

        $('#filter').on('click', function() {
            const filters = {
                company_id: $('#company').val(),
                division_id: $('#division').val(),
                level_id: $('#level').val(),
                gender_id: $('#gender').val(),
            };

            $.ajax({
                url: '/api/employee-periods/filter',
                data: filters,
                success: function(response) {
                    const labels = response.map(item => formatPeriod(item.period));
                    const data = response.map(item => item.employee_count);
                    const colors = generateColors(data.length);

                    chart.data.labels = labels;
                    chart.data.datasets[0].data = data;
                    chart.data.datasets[0].backgroundColor = colors;
                    chart.data.datasets[0].borderColor = colors.map(color => color.replace('0.5', '1'));
                    chart.update();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    </script>
</body>
</html>
