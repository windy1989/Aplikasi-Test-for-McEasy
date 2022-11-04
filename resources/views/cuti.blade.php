<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-primary btn-raised btn-round" data-toggle="modal" data-target="#modalCuti">
					<span class="material-icons">
						add_circle_outline
					</span>
					Tambah Cuti
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
						<i class="material-icons">date_range</i>
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
										<th>Tgl.Cuti</th>
										<th>Lama Cuti</th>
										<th>Keterangan</th>
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

<div class="modal fade" id="modalCuti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
					<form id="formcuti" class="form-horizontal">
						<div class="card-header card-header-text" data-background-color="rose">
							<h4 class="card-title">Form Cuti</h4>
						</div>
						<div class="card-content">
                            <div class="alert alert-danger" id="validation_alert" style="display:none;">
                                <ul id="validation_content"></ul>
                             </div>
							<div class="row">
								<label class="col-sm-3 label-on-left">Karyawan</label>
								<div class="col-sm-9">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<input type="hidden" id="temp" name="temp">
										<select class="form-control" id="karyawan" name="karyawan" style="width:100%;"></select>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-3 label-on-left">Tanggal Cuti</label>
								<div class="col-sm-9">
									<div class="form-group">
                                        <input type="date" class="form-control datepicker" value="{{ date('Y-m-d') }}" id="tanggal_cuti" name="tanggal_cuti" autocomplete="off">
										<span class="help-block">Tanggal cuti</span>
                                    </div>
								</div>
							</div>
                            <div class="row">
								<label class="col-sm-3 label-on-left">Jumlah Cuti (Hari)</label>
								<div class="col-sm-9">
									<div class="form-group">
                                        <input type="number" class="form-control" value="1" id="jumlah_hari" name="jumlah_hari" autocomplete="off">
										<span class="help-block">Jumlah hari cuti</span>
                                    </div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-3 label-on-left">Keterangan</label>
								<div class="col-sm-9">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<textarea class="form-control" id="keterangan" name="keterangan" autocomplete="off"></textarea>
										<span class="help-block">Keterangan tidak masuk.</span>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="simpanCuti()">Simpan</button>
			</div>
		</div>
	</div>
</div>

<script>
    $(function() {
       var table = loadDataTable();

	   	$('#modalPegawai').on('hidden.bs.modal', function (e) {
			$('#temp').val('');
            $('#formcuti')[0].reset();
            $('#karyawan').empty();
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
						url: '{{ url("cuti/destroy") }}',
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
					url: '{{ url("cuti/get") }}',
					type: 'GET',
					dataType: 'JSON',
					data: {
						id: id
					},
					beforeSend: function() {
						
					},
					success: function(response) {
						Pace.stop();

						$('#modalCuti').modal('toggle');

						$('#temp').val(id);
						$('#karyawan').empty();
                        $('#karyawan').append(`
                            <option value="` + response.id_karyawan + `">` + response.detail_karyawan + `</option>
                        `);
						$('#tanggal_cuti').val(response.tanggal_cuti);
						$('#jumlah_hari').val(response.jumlah_hari);
						$('#keterangan').val(response.keterangan);
					},
					error: function() {
						Pace.stop();
					}
				});
			});
		});

        $('#karyawan').select2({
            placeholder: '-- Cari dari no induk / nama karyawan --',
            minimumInputLength: 3,
            allowClear: true,
            cache: true,
            dropdownParent: $('.modal-body').parent(),
            ajax: {
                url: '{{ url("karyawan/select2") }}',
                type: 'GET',
                dataType: 'JSON',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.items
                    }
                }
            }
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
                order: [[2, 'asc']],
                ajax: {
                    url: '{{ url("cuti/datatable") }}',
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
                    { name: 'no', orderable: false, className: 'text-center align-middle' },
                    { name: 'tgl_cuti', className: 'text-center align-middle' },
                    { name: 'lama_cuti', className: 'text-center align-middle' },
                    { name: 'keterangan', className: 'text-center align-middle' },
                    { name: 'action', searchable: false, orderable: false, className: 'text-center nowrap align-middle' }
                ]
            });
        }); 
    }

    function simpanCuti() {
        Pace.restart();
	    Pace.track(function () {
            $.ajax({
                url: '{{ url("cuti/create") }}',
                type: 'POST',
                dataType: 'JSON',
                data: new FormData($('#formcuti')[0]),
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
                        $('#formcuti')[0].reset();

                        loadDataTable();

                        $('#modalCuti').modal('toggle');
                        
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