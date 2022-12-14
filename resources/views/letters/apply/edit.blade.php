@extends('layouts.app')
@section('title')
  CKEditor
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
      <h3 class="page__heading">Edit Form {{ $letter->name }} atas nama {{ $letter->user->name }}</h3>
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

                <form action="{{ route('letters.apply.update', [$letter->user->department_id ,$letter->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                           
                            </style>
                            <textarea name="html" id="html" rows="10" cols="80">
                              {{ $letter->html }}
                            </textarea>
                          </div>
                      </div>    
                  </div>
                  <div class="form-group">
                    <label for="">File Evidence</label>                                    
                    {!! Form::file('file', null, array('class' => 'form-control')) !!}
                  </div>
                  <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection

@section('page_js')
<script src="{{ asset('js/ckeditor-4-19/ckeditor.js') }}"></script>
@endsection

@section('scripts')
<script>
  CKEDITOR.replace('html');
  CKEDITOR.config.height = 1350;
</script>
@endsection