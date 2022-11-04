<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-primary btn-raised btn-round" data-toggle="modal" data-target="#modalPegawai">
					<span class="material-icons">
						add_circle_outline
					</span>
					Tambah Pegawai
				</button>
				<button class="btn btn-info btn-raised btn-round" onclick="loadDataTable()">
					<span class="material-icons">
						refresh
					</span>
					Refresh Tabel
				</button>
			</div>
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">person_pin</i>
					</div>
					<div class="card-content">
						<h4 class="card-title">Daftar Pegawai</h4>
						<div class="toolbar">
							<!--        Here you can write extra buttons/actions for the toolbar              -->
						</div>
						<div class="material-datatables table-responsive">
							<table id="datatable_serverside" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>No</th>
										<th>No.Induk</th>
										<th>Nama</th>
										<th>Alamat</th>
										<th>Tgl.Lahir</th>
										<th>Tgl.Gabung</th>
										<th width="10%">#</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					<!-- end content-->
				</div>
				<!--  end card  -->
			</div>
			<!-- end col-md-12 -->
		</div>
		<!-- end row -->
	</div>
</div>

<div class="modal fade" id="modalPegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="material-icons">clear</i>
				</button>
				<h4 class="modal-title">Tambah/Edit</h4>
			</div>
			<div class="modal-body">
				<div class="card">
					<form id="formpegawai" class="form-horizontal">
						<div class="card-header card-header-text" data-background-color="rose">
							<h4 class="card-title">Form Pegawai</h4>
						</div>
						<div class="card-content">
                            <div class="alert alert-danger" id="validation_alert" style="display:none;">
                                <ul id="validation_content"></ul>
                             </div>
                            <div class="row">
								<label class="col-sm-3 label-on-left">No.Induk</label>
								<div class="col-sm-9">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<input type="text" class="form-control" id="no_induk" name="no_induk" autocomplete="off">
										<span class="help-block">Ex. IP0001</span>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-3 label-on-left">Nama</label>
								<div class="col-sm-9">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<input type="hidden" id="temp" name="temp">
										<input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
										<span class="help-block">Ex. Budi Setio</span>
									</div>
								</div>
							</div>
                            <div class="row">
								<label class="col-sm-3 label-on-left">Alamat</label>
								<div class="col-sm-9">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<textarea class="form-control" id="alamat" name="alamat" autocomplete="off"></textarea>
										<span class="help-block">Alamat sesuai kartu identitas.</span>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-3 label-on-left">Tgl.Lahir</label>
								<div class="col-sm-9">
									<div class="form-group">
                                        <input type="date" class="form-control datepicker" value="{{ date('Y-m-d') }}" id="tanggal_lahir" name="tanggal_lahir" autocomplete="off">
										<span class="help-block">Tanggal lahir</span>
                                    </div>
								</div>
							</div>
                            <div class="row">
								<label class="col-sm-3 label-on-left">Tgl.Gabung</label>
								<div class="col-sm-9">
									<div class="form-group">
                                        <input type="date" class="form-control datepicker" value="{{ date('Y-m-d') }}" id="tanggal_gabung" name="tanggal_gabung" autocomplete="off">
										<span class="help-block">Tanggal Gabung Perusahaan</span>
                                    </div>
								</div>
							</div>
							
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="simpanKaryawan()">Simpan</button>
			</div>
		</div>
	</div>
</div>

<script>
    $(function() {
       var table = loadDataTable();

	   	$('#modalPegawai').on('hidden.bs.modal', function (e) {
			$('#temp').val('');
            $('#formpegawai')[0].reset();
		});

		$('#datatable_serverside tbody').on('click', '.remove', function(e) {
			var id = $(this).data('id');
			
			swal({
				title: 'Yakin?',
				text: 'Anda tidak akan bisa mengembalikan data ini!',
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya, hapus!',
				cancelButtonText: 'Jangan dulu!',
				confirmButtonClass: "btn btn-success",
				cancelButtonClass: "btn btn-danger",
				buttonsStyling: false
			}).then(function() {
				Pace.restart();
				Pace.track(function () {
					$.ajax({
						url: '{{ url("karyawan/destroy") }}',
						type: 'POST',
						dataType: 'JSON',
						data: {
							id: id
						},
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						success: function(response) {
							if(response.status == 200) {
								$('#datatable_serverside').DataTable().ajax.reload(null, false);
								
								swal({
									title: 'Hurray!',
									text: response.message,
									type: 'success'
								});
							} else {
								swal({
									title: 'Ups!',
									text: response.message,
									type: 'error'
								});
							}

							Pace.stop();
						},
						error: function() {
							Pace.stop();
						}
					});
				});
				
			}, function(dismiss) {
			if (dismiss === 'cancel') {
				swal({
					title: 'Tercancel',
					text: 'Data anda aman :)',
					type: 'error'
				})
				Pace.stop();
			}
			});
		});

	   	$('#datatable_serverside tbody').on('click', '.edit', function() {
			var id = $(this).data('id');
			Pace.restart();
	   		Pace.track(function () {
				$.ajax({
					url: '{{ url("karyawan/get") }}',
					type: 'GET',
					dataType: 'JSON',
					data: {
						id: id
					},
					beforeSend: function() {
						
					},
					success: function(response) {
						Pace.stop();

						$('#modalPegawai').modal('toggle');

						$('#temp').val(id);
						$('#nama').val(response.name);
						$('#no_induk').val(response.no);
						$('#alamat').val(response.address);
						$('#tanggal_lahir').val(response.date_birth);
						$('#tanggal_gabung').val(response.date_join);
					},
					error: function() {
						Pace.stop();
					}
				});
			});
		});
    });

    function loadDataTable() {
        Pace.restart();
	    Pace.track(function () {
            return $('#datatable_serverside').DataTable({
                serverSide: true,
                deferRender: true,
                destroy: true,
				responsive: true,
                iDisplayInLength: 10,
                order: [[1, 'asc']],
                ajax: {
                    url: '{{ url("karyawan/datatable") }}',
                    type: 'GET',
                    beforeSend: function() {
                    
                    },
                    complete: function() {
                        Pace.stop();
                    },
                    error: function() {
                        Pace.stop();
                        swal({
                            title: 'Ups!',
                            text: 'Cek koneksi anda.',
                            type: 'error'
                        });
                    }
                },
                columns: [
                    { name: 'id', searchable: false, className: 'text-center align-middle' },
                    { name: 'no', className: 'text-center align-middle' },
                    { name: 'nama', className: 'text-center align-middle' },
                    { name: 'alamat', className: 'text-center align-middle' },
                    { name: 'tgl_lahir', className: 'text-center align-middle' },
                    { name: 'tgl_gabung', className: 'text-center align-middle' },
                    { name: 'action', searchable: false, orderable: false, className: 'text-center nowrap align-middle' }
                ]
            });
        }); 
    }

    function simpanKaryawan() {
        Pace.restart();
	    Pace.track(function () {
            $.ajax({
                url: '{{ url("karyawan/create") }}',
                type: 'POST',
                dataType: 'JSON',
                data: new FormData($('#formpegawai')[0]),
                contentType: false,
                processData: false,
                cache: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#validation_alert').hide();
                    $('#validation_content').html('');
                    
                },
                success: function(response) {
                    Pace.stop();

                    if(response.status == 200) {
                        swal({
                            title: 'Hooray!',
                            text: response.message,
                            type: 'success'
                        });
                        
                        $('#temp').val('');
                        $('#formpegawai')[0].reset();

                        loadDataTable();

                        $('#modalPegawai').modal('toggle');
                        
                    } else if(response.status == 422) {

                        $('#validation_alert').show();

                        $('.modal-body').scrollTop(0);

                        swal({
                            title: 'Ups!',
                            text: 'Validation',
                            type: 'error'
                        });
                        
                        $.each(response.error, function(i, val) {
                            $.each(val, function(i, val) {
                                $('#validation_content').append(`
                                    <li>` + val + `</li>
                                `);
                            });
                        });
                    } else {
                        swal({
                            title: 'Ups!',
                            text: response.message,
                            type: 'error'
                        });
                    }
                },
                error: function() {
                    $('.modal-body').scrollTop(0);
                    Pace.stop();
                    
                }
            });
        });
    }
</script>