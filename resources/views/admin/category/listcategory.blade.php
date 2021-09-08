@extends('admin.admin_master')
@section('admin')
<div class="container-full">
        <!-- form started -->
    <section class="content">

    <!-- FORM START -->
    <div class="row mb-15">
    <div class="col-md-6">
    
    @if(isset($editcategory))
        <form method="post" action="{{ route('admin.category.update', $editcategory->id) }}" class='form-group'>

    @else
            <form class='form-group' method="post" action="{{ route('admin.category.store') }}">
    @endif
    @csrf
        <div class="input-group">
        <input type="text" name="namacategory" class="form-control" placeholder="Save Category" value="{{(isset($editcategory)) ? $editcategory->namacategory : ''}}">
        <span class="input-group-append">
        @if (isset($editcategory))
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
        <h4 class="box-title">Kategori Table</h4>
        <div class="box-controls pull-right">
        <div class="lookup lookup-circle lookup-right">
            <input type="text" name="s">
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
                <th>Nama Kategori</th>
                <th></th>
            </tr>
           <?php
            $page = (isset($_GET['page'])) ? $_GET['page']: 0;
            $no =1 + $page; ?>
            @foreach($categ as $row)
            <tr>
                <td><?php echo $no++; ?></td>
                <td>{{ $row->namacategory}}</td>
                <td>
                    <a href="{{route('admin.category.edit', $row->id)}}" class='btn btn-primary btn-sm'>
                       <i class="fa fa-edit"></i> Edit
                    </a>
                     <a href="{{route('admin.category.delete', $row->id)}}" class='btn btn-danger btn-sm' id="delete">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
            </table>
            {{$categ->links("pagination::bootstrap-4")}}
            
            
        </div>
        
    </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
    </section>
</div>
@endsection