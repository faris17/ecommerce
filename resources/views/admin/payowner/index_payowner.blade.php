@extends('admin.admin_master')
@section('admin')
    <div class="container-full">
        <!-- form started -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Tansaksi Pembayaran Owner</h4>
                    <div class="box-controls pull-right">
                        <button type="button" class="btn btn-rounded btn-info" data-toggle="modal"
                            data-target="#modal-center">
                            Pencarian
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Usaha</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Expire</th>
                                    <th></th>
                                </tr>
                                <?php
                                $page = isset($_GET['page']) ? $_GET['page'] : 0;
                                $no = 1 + $page; ?>
                                @foreach ($data as $row)
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>{{ $row->owner->namausaha }}</td>
                                        <td>{{ $row->typeowner->nametypeowner }}</td>
                                        <td> @currency($row->harga)</td>
                                        <td>@php
                                            $tglbayar = date('d/m/Y', strtotime($row->tanggalbayar));
                                            echo $tglbayar;
                                        @endphp</td>
                                        <td>
                                            @php
                                                $date = $row->tanggalbayar;
                                                $date = strtotime($date);
                                                $expire = strtotime('+ 1 year', $date);
                                                echo date('d/m/Y', $expire);

                                            @endphp
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-rounded btn-outline btn-sm btn-dark dropdown-toggle"
                                                    type="button" data-toggle="dropdown"
                                                    aria-expanded="false">Action</button>
                                                <div class="dropdown-menu" style="will-change: transform;">
                                                    <a class="dropdown-item btn btn-primary btn-sm"
                                                        href="{{ route('admin.payowner.create', $row->id) }}"><i
                                                            class="fa fa-plus"></i> New Transaction</a>
                                                    <a href="{{ route('admin.payowner.edit', $row->id) }}"
                                                        class='dropdown-item '>
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>

                                                    <div class="dropdown-divider"></div>
                                                    <a href="{{ route('admin.owner.delete', $row->id) }}"
                                                        class='btn btn-danger btn-sm dropdown-item' id="delete">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>

                                                </div>
                                            </div>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $data->links('pagination::bootstrap-4') }}


                    </div>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
    </div>

    <!-- MODAL -->
    <div class="modal center-modal fade" id="modal-center" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pencarian</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="get" action="{{ route('admin.payowner.index') }}">

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Berdasarkan Nama</label>
                            <input type="text" name="namausaha" placeholder="Nama Usaha" class='form-control col-md-10' />

                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input name="tahun" type="text" class="form-control col-md-4" id="tahun">
                        </div>

                    </div>
                    <div class="modal-footer modal-footer-uniform">
                        <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-rounded btn-primary float-right"><i class="fa fa-search"></i>
                            Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
