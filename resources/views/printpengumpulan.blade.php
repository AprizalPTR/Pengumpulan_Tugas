<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Siswa</title>
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2.5rem;
            margin: 0;
            color: #0066ff;
            text-transform: uppercase;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        .table th, .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #0066ff;
            color: #fff;
            text-transform: uppercase;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Data Pengumpulan</h1>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Absen</th>
                        <th scope="col">Mapel</th>
                        <th scope="col">Tugas</th>
                        <th scope="col">Tanggal Pengumpulan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($printpengumpulan as $p)
                        <tr>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $p->Nama_Siswa }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $p->No_Absen }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $p->Nama_Mapel }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $p->Nama_Tugas }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $p->Tanggal_pengumpulan }}
                                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
