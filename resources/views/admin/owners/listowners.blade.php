@extends('admin.admin_master')
@section('admin')
    <div class="container-full">
        <!-- form started -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Onwer</h4>
                    <div class="box-controls pull-right">
                        <a href="{{ route('admin.owner.create') }}">
                            <button class='btn btn-info'><i class="fa fa-plus"></i> Tambah </button>
                        </a>
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
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                <?php
                                $page = isset($_GET['page']) ? $_GET['page'] : 0;
                                $no = 1 + $page; ?>
                                @foreach ($owners as $row)
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>{{ $row->namausaha }}</td>
                                        <td>{!! $row->deskripsiowner !!}</td>
                                        <td>{{ $row->status }}</td>
                                        <td>
                                            <a href="{{ route('admin.owner.edit', $row->id) }}"
                                                class='btn btn-primary btn-sm'>
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ route('admin.owner.delete', $row->id) }}"
                                                class='btn btn-danger btn-sm' id="delete">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $owners->links('pagination::bootstrap-4') }}


                    </div>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
    </div>
@endsection
