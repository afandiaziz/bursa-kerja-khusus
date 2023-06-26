<table>
    <thead>
        <tr style="background-color: #F8C2A0; font-weight: bold">
            <th style="vertical-align: top;background-color: #F8C2A0; font-weight: bold;">Perusahaan</th>
            <th style="vertical-align: top;background-color: #F8C2A0; font-weight: bold;">Posisi</th>
            <th style="vertical-align: top;background-color: #F8C2A0; font-weight: bold;">Nomor Registrasi</th>
            <th style="vertical-align: top;background-color: #F8C2A0; font-weight: bold;">Nama</th>
            <th style="vertical-align: top;background-color: #F8C2A0; font-weight: bold;">Email</th>
            <th style="vertical-align: top;background-color: #F8C2A0; font-weight: bold;">Status Verifikasi <br> Pendaftaran</th>
            <th style="vertical-align: top;background-color: #F8C2A0; font-weight: bold;">CV</th>
            @foreach ($applicants[0]->vacancy->vacancyCriteriaOrdered() as $item)
                <td style="vertical-align: top;background-color: #F8C2A0; font-weight: bold;">{{ $item->name }}</td>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($applicants as $applicant)
            <tr>
                <td style="vertical-align: top;">'{{ $applicant->vacancy->company->name }}</td>
                <td style="vertical-align: top;">'{{ $applicant->vacancy->position }}</td>
                <td style="vertical-align: top;">'{{ $applicant->registration_number }}</td>
                <td style="vertical-align: top;">'{{ $applicant->user->name }}</td>
                <td style="vertical-align: top;">'{{ $applicant->user->email }}</td>
                <td style="vertical-align: top;">{{ $applicant->verified ? 'Terverifikasi' : 'Belum Terverifikasi' }}</td>
                <td style="vertical-align: top;"><a href="{{ url(asset('assets/upload/cv/' . $applicant->user->cv)) }}">{{ $applicant->user->cv }}</a></td>
                @foreach ($applicant->vacancy->vacancyCriteriaOrdered() as $item)
                    <td style="vertical-align: top;">'@include('components.criteria', ['criteria' => $item, 'data' => $applicant->applicant_details, 'child' => $applicant, 'forExport' => true]) </td>
                @endforeach
        @endforeach
    </tbody>
</table>
