<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni</title>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <section id="bagian-job">
        <h2>Alumni</h2>

        <table id="alumniTable">
            <thead>
                <tr>
                    <th>Nama Alumni</th>
                    <th>NIM</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alumni as $item)
                    <tr>
                        <td>{{ $item['nama_alumni'] }}</td>
                        <td>{{ $item['nim'] }}</td>
                        <td>{{ $item['status'] }}</td>
                        <td>{{ $item['email'] }}</td>
                        <td>{{ $item['no_tlp'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <script>
        $(document).ready(function() {
            $('#alumniTable').DataTable();
        });
    </script>
</body>
</html>
