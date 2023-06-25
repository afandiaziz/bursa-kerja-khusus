<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Bukti Pendaftaran</title>
</head>
<body>
	<table width="100%">
		<tr>
			<th align="center">
				<p  style="font-weight: bold;">
					<span style="font-size: 28px">Bukti Pendaftaran</span>
					<br><span style="font-size: 18px">Bursa Kerja Khusus</span>
				</p>
			</th>
		</tr>
	</table>
	<hr>
	<br>
	<p><b>Nomor Registrasi : {{ $data->registration_number }}</b></p>
	<p>Dokumen ini menyatakan bahwa : </p>
	<table>
		<tr>
			<td><b>Nama Pelamar</b></td><td><b>:</b></td><td>
                &nbsp;{{ $data->user->name }}
            </td>
		</tr>
		<tr>
			<td><b>Email</b></td><td><b>:</b></td>
            <td>
                &nbsp;{{ $data->user->email }}
            </td>
		</tr>
		<tr>
			<td><b>No. Handphone</b></td><td><b>:</b></td>
            <td>
                &nbsp;{{ $data->user->name }}
            </td>
		</tr>
		<tr>
			<td><b>Tanggal Registrasi &nbsp;&nbsp;</b></td><td><b>:</b></td><td>
                &nbsp;{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y H:i') }}
            </td>
		</tr>
	</table>
	<br>
	<p>Telah mendaftar sebagai calon pelamar pada : </p>
	<br>
	<table>
		<tr>
			<td><b>Perusahaan&nbsp;&nbsp;</b></td><td><b>:</b></td>
            <td>
                &nbsp;{{ $data->vacancy->company->name }}
            </td>
		</tr>
		<tr>
			<td><b>Sebagai</b></td><td><b>:</b></td>
            <td>
                &nbsp;{{ $data->vacancy->position }}
            </td>
		</tr>
	</table>
    <p>
        <b>Status Verifikasi Pelamar:</b>
        @if ($data->verified)
            <span style="color: green">Terverifikasi</span>
        @else
            <span style="color: red">Belum Terverifikasi</span>
        @endif
    </p>
    @if ($data->vacancy->information)
        <br>
        <br>
        <strong>
            Informasi Tambahan:
        </strong>
        {!! $data->vacancy->information !!}
    @endif
    <br>
    <br>
    <br>
    <br>
    <p align="center">
        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($data->registration_number, 'C128A', 1.8, 65) }}" alt="barcode" />
        <div align="center">{{ $data->registration_number }}</div>
    </p>
</body>
</html>
