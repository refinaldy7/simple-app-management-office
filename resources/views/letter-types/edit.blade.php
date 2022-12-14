@extends('layouts.app')
@section('title')
  Upload Template Form
@endsection

@section('css')
    <style>
        table {
    border: 1px solid #000;
}
td {
    border-width: 0;
}
thead td, thead th {
    border-width: 0 0 1px 0;
}
    </style>
@endsection

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Edit Form {{ $letterType->name }}</h3>
  </div>
  <div class="section-body">
      <div class="row">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                  
                  @if ($errors->any())                                                
                      <div class="alert alert-dark alert-dismissible fade show" role="alert">
                      <strong>Error!</strong>                        
                          @foreach ($errors->all() as $error)                                    
                              <span class="badge badge-danger">{{ $error }}</span>
                          @endforeach                        
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      </div>
                  @endif


                  {!! Form::model($letterType, array('route' => array('letter-types.update', $letterType->id),'method'=>'PUT', 'enctype' => 'multipart/form-data')) !!}
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                            <label for="name">Jenis Form</label>
                            {!! Form::text('name', $letterType->name, array('class' => 'form-control')) !!}
                          </div>
                      </div>    
                  </div>
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                            <label for="description">Deskripsi Form</label>
                            {!! Form::text('description', $letterType->description, array('class' => 'form-control')) !!}
                          </div>
                      </div>    
                  </div>

                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                            <label for="lama">Form Lama : </label> <br/>
                            <a  href="{{ route('letter-types.download',$letterType->id) }}">{{ $letterType->file_path ?? 'Belum ada form yang diupload'}}</a>
                          </div>
                      </div>    
                  </div>
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                            <label for="file">Upload Form Baru</label>
                            {!! Form::file('file', null, array('class' => 'form-control')) !!}
                          </div>
                      </div>    
                  </div>
                  
                  <button type="submit" class="btn btn-primary">Save</button>
                  {!! Form::close() !!}
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection
