<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>Basic Header Cuba - Premium Admin Template</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <style type="text/css">
        body {
            width: 650px;
            font-family: Rubik, sans-serif;
            background-color: #f6f7fb;
            display: block;
        }

        a {
            text-decoration: none;
        }

        span {
            font-size: 14px;
        }

        p {
            font-size: 13px;
            line-height: 1.7;
            letter-spacing: 0.7px;
            margin-top: 0;
        }

         ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        p {
            margin: 15px 0;
        }

        h5 {
            color: #444;
            text-align: left;
            font-weight: 400;
        }

        .text-center {
            text-align: center
        }

        h6 {
            font-size: 16px;
            margin: 0 0 18px 0;
        }

        table.order-template {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        table.order-template tr:nth-child(even) {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        table.order-template tr:nth-child(odd) {
            border-bottom: 1px solid #ddd;
        }

        .order-template th {
            font-size: 15px;
            padding: 15px;
            text-align: center;
            background: #fafafa;
        }

        @media only screen and (max-width: 767px) {
            body {
                width: auto;
                margin: 20px auto;
            }

            .logo-sec {
                width: 500px !important;
            }
        }

        @media only screen and (max-width:575px) {
            body {
                width: 90%;
            }

            .order-template tbody tr:nth-child(n+2) td img {
                width: 40px;
            }

            .order-template tbody tr td:nth-child(3),
            .order-template tbody tr th:nth-child(3) {
                display: none;
            }

            .order-template tbody tr td,
            .order-template tbody tr th {
                width: 50px;
            }

            .content-detail tbody tr {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 12px;
            }

            .content-detail tbody tr td:nth-child(2) {
                display: none;
            }

            table tbody td>table:first-child {
                text-align: center !important;
            }
        }

        @media only screen and (max-width: 480px) {
            .order-template th,
            .order-template td h5 {
                font-size: 13px !important;
            }
        }

        @media only screen and (max-width: 360px) {
            .logo-sec {
                width: 250px !important;
            }

            .order-template th,
            .order-template td h5 {
                font-size: 12px !important;
            }

            .order-template tbody tr td {
                padding-left: 0 !important;
            }

            .order-template tbody tr:nth-child(n+2) td img {
                width: 34px;
            }

            .order-template tr th:nth-child(n+2) {
                padding-left: 0 !important;
            }
        }
    </style>
</head>

<body style="margin: 30px auto;">
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    <table style="background-color: #f6f7fb; width: 100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table style="margin: 0 auto; margin-bottom: 30px">
                                        <tbody>
                                            <tr class="logo-sec"
                                                style="display: flex; align-items: center; justify-content: space-between; width: 650px;">
                                                <td><img class="img-fluid"
                                                        src="{{ asset('assets/images/other-images/logo-login.png') }}"
                                                        alt=""></td>
                                                {{-- <td style="text-align: right; color:#999"><span>Some Description</span>
                                                </td> --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="margin: 0 auto; background-color: #fff; border-radius: 8px">
                        <tbody>
                            <tr>
                                <td style="padding: 30px">
                                    <h6 style="font-weight: 600">LPSE</h6>
                                    <p>Berikut Data Tender LPSE yang tayang hari ini :</p>
                                    
                                    <table class="order-template" border="0" cellpadding="0" cellspacing="0" align="left" style="width: 100%; margin-bottom: 50px;">
                        <tbody>
                            <tr align="left">
                                <th style="padding-left: 15px;">KODE PAKET</th>
                                <th style="padding-left: 15px;">NAMA PAKET</th>
                                <th style="padding-left: 15px;">TAHAPAN</th>
                                <th>HPS</th>
                            </tr>
                            @foreach ($datas as $data)
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td valign="top" style="padding-left: 15px;">
                                        <h5 style="margin-top: 15px;">
                                            {{ $data->tender->hps}}
                                        </h5>
                                    </td>
                                    <td valign="top" style="padding-left: 15px;">
                                        <h5 style="margin-top: 15px;">
                                            <a href="{{ route('redirect.tender',['tender' => $data->tender->slug])}}">
                                                {{ $data->tender->nama_paket}}
                                            </a>
                                            <br>
                                            {{ $data->tender->nama_lpse}}
                                            <br>
                                            {{ $data->tender->kategori}} - {{ $data->tender->metode_pemilihan}} - {{ $data->tender->metode_pengadaan}}
                                        </h5>
                                    </td>
                                    <td valign="top" style="padding-left: 15px;">
                                        <h5 style="margin-top: 15px;">
                                            {{ $data->tender->tahap_tender}}
                                        </h5>
                                    </td>
                                    <td valign="top" style="padding-left: 15px;padding-right: 15px;">
                                        <h5 style="font-size: 14px; color:#444;margin-top:15px;    margin-bottom: 0px;">
                                            {{ App\Helpers\TableHelper::nominal_simple($data->tender->hps)}}
                                        </h5>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                                    <p style="margin-bottom: 0">
                                        Regards,<br>LPSE Indonesia</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="margin: 0 auto; margin-top: 30px">
                        <tbody>
                            <tr style="text-align: center">
                                <td>
                                    <p style="color: #999; margin-bottom: 0">Powered By LPSE Indonesia</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
