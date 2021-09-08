@extends('admin.admin_master')
@section('admin')
    <div class="container-full">
        <!-- form started -->
        <section class="content">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ implode('', $errors->all(':message')) }}
                </div>

            @endif

            <!-- FORM START -->
            <div class="row mb-15">

                <div class="col-md-6">

                    @if (isset($edit))
                        <form method="post" action="{{ route('admin.bank.update', $edit->id) }}" class='form-group'>

                        @else
                            <form class='form-group' method="post" action="{{ route('admin.bank.store') }}">
                    @endif
                    @csrf
                    <div class="input-group">
                        <input type="text" name="kode" class="col-md-2 form-control" placeholder="Kode"
                            value="{{ isset($edit) ? $edit->kode : '' }}">
                        <input type="text" name="namabank" class="form-control" placeholder="Nama Bank"
                            value="{{ isset($edit) ? $edit->namabank : '' }}">
                        <span class="input-group-append">
                            @if (isset($edit))
                                <button type='submit' class='btn btn-warning'><i class="fa fa-save"></i> Update</button>

                            @else
                                <button type='submit' class='btn btn-primary'><i class="fa fa-save"></i> Save</button>
                            @endif

                        </span>
                    </div>
                    </form>
                </div>
            </div>
            <!-- FORM -->

            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Bank Table</h4>
                    <div class="box-controls pull-right">
                        <div class="lookup lookup-circle lookup-right">
                            <form method="get" action="{{ route('admin.bank') }}">
                                <input type="text" name="keyword" value='{{ request('keyword') }}'
                                    style='background-color:white'>
                                <input type="submit" style='background-color:rgb(211, 192, 255); color:white;'
                                    value='cari' />
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Bank</th>
                                    <th></th>
                                </tr>
                                <?php
                                $page = isset($_GET['page']) ? $_GET['page'] : 0;
                                $no = 1 + $page; ?>
                                @foreach ($bank as $row)
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>{{ $row->kode }}</td>
                                        <td>{{ $row->namabank }}</td>
                                        <td>
                                            <a href="{{ route('admin.bank.edit', $row->id) }}"
                                                class='btn btn-primary btn-sm'>
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ route('admin.bank.delete', $row->id) }}"
                                                class='btn btn-danger btn-sm' id="delete">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $bank->links('pagination::bootstrap-4') }}


                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
    </div>
@endsection
