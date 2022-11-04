
     <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">weekend</i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Karyawan Pertama Gabung (3)</h3>
                        </div>
                        <div class="card-body">
                            <div class="material-datatables table-responsive">
                                <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Induk</th>
                                            <th>Nama</th>
                                            <th>Tgl.Gabung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($karyawanPertamaGabung as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->no }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->date_join }}</td>
                                            <tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="rose">
                            <i class="material-icons">today</i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Karyawan Yang Pernah Mengambil Cuti</h3>
                        </div>
                        <div class="card-body">
                            <div class="material-datatables table-responsive">
                                <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Induk</th>
                                            <th>Nama</th>
                                            <th>Tgl.Cuti</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($karyawanPernahMengambilCuti as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->employee->no }}</td>
                                                <td>{{ $row->employee->name }}</td>
                                                <td>{{ $row->date_leave }}</td>
                                                <td>{{ $row->note }}</td>
                                            <tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="gold">
                            <i class="material-icons">preview</i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Karyawan Cuti Lebih Dari Satu</h3>
                        </div>
                        <div class="card-body">
                            <div class="material-datatables table-responsive">
                                <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Induk</th>
                                            <th>Nama</th>
                                            <th>Tgl.Cuti</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($karyawanCutiLebihDariSatu as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->employee->no }}</td>
                                                <td>{{ $row->employee->name }}</td>
                                                <td>{{ $row->date_leave }}</td>
                                                <td>{{ $row->note }}</td>
                                            <tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="blue">
                            <i class="material-icons">edit_calendar</i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Sisa Cuti Karyawan</h3>
                        </div>
                        <div class="card-body">
                            <div class="material-datatables table-responsive">
                                <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Induk</th>
                                            <th>Nama</th>
                                            <th>Sisa Cuti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($karyawanSisaCuti as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->no }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->sisaCuti().' hari' }}</td>
                                            <tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    