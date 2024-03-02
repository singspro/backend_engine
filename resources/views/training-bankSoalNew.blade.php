@extends('layouts/main')

@section('container')
<div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
          <h5 class="card-title">Lets... Create New Questions.. !</h5>
        </div>
      </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="/soalNewSubmit1" enctype="multipart/form-data" method="POST">
            @csrf
        <div class="mb-3 mt-3">
            <label for="formGroupExampleInput" class="form-label">Judul Soal</label>
            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" id="formGroupExampleInput" value="{{old('judul')}}" placeholder="Contoh : Product Knowledge Excavator PC01-0">
           @error('judul')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
          <div class="mb-3">
            <label for="formGroupExampleInput2" class="form-label">Author</label>
            <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" id="formGroupExampleInput2" value="{{old('author')}}" placeholder="Isi nama pembuat soal">
            @error('author')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
          <button class="btn btn-primary" type="submit" >Next</button>
        </form>
    </div>
</div>
@endsection