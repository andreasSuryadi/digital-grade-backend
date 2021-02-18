<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Laporan Pembelajaran</title>
    <meta name="author" content="Yarn Spindle">
    <style type="text/css">
        @media print {
            @page {
                size: A4;
                margin: 5px;
            }
        }

        * {
            font-family: Helvetica, Arial, sans-serif;
            font-size: small;
        }

        table {
            table-layout: fixed;
            border-collapse: collapse;
            width: 100%;
        }

        .font-table {
            font-size: 1em;
            float: right;
        }

        th {
            text-align: left
        }

        .page-break {
            page-break-before: always;
            /* page-break-after: always; */
        }
    </style>
</head>

<body>
    <h1><center>Laporan Pembelajaran</center></h1>

    <header>
        <table>
            <tr>
                <th style="width: 20%">Nama</th>
                <td style="width: 30%">{{ $name }}</td>
                <th style="width: 20%">NISN / NIS</th>
                <td style="width: 30%">{{ $nisn }}/{{ $nis }}</td>
            </tr>
            <tr>
                <th>Kelas / Semester</th>
                <td>{{ $class }} / {{ $semester }}</td>
                <th>Tahun Ajaran</th>
                <td>{{ $startYear }} / {{ $endYear }}</td>
            </tr>
        </table>
    </header>

    <br />
    <br />

    <main>
        <table border="1">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 25%">Course</th>
                    <th style="width: 10%">Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $key => $grade)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $grade['course'] }}</td>
                    <td>{{ $grade['grade'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <br />
    <br />

    <footer>
        <table>
            <tr>
                <th style="text-align: center;width: 20%">Orang Tua/Wali</th>
                <th style="text-align: center;width: 20%"></th>
                <th style="text-align: center;width: 20%"></th>
                <th style="text-align: center;width: 20%"></th>
                <th style="text-align: center;width: 20%">Wali Kelas</th>
            </tr>
            <tr>
                <td valign="bottom" style="text-align: center;height: 10%">(...........................)</td>
                <td valign="bottom" style="text-align: center;height: 10%"></td>
                <td valign="bottom" style="text-align: center;height: 10%"></td>
                <td valign="bottom" style="text-align: center;height: 10%"></td>
                <td valign="bottom" style="text-align: center;height: 10%">(...........................)</td>
            </tr>
        </table>
    </footer>
</body>

</html>