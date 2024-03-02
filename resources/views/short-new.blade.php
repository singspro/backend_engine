@extends('layouts/main')

@section('container')
<div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
          <h5 class="card-title">Create URL shorten and unique</h5>
        </div>
      </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="/submitNewShort" enctype="multipart/form-data" method="POST">
            @csrf
        <div class="mb-3 mt-3">
            <label for="formGroupExampleInput" class="form-label">Short Url</label>
            <input type="text" name="urlShort" class="form-control @error('urlShort') is-invalid @enderror" id="formGroupExampleInput" value="{{old('urlShort')}}" placeholder="contoh:personaldata">
            <div id="emailHelp" class="form-text">https://ppdmaco.com/link_(<strong>short Url</strong>)</div>
            @error('urlShort')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
          <div class="mb-3">
            <label for="formGroupExampleInput2" class="form-label">Target URL (Redirect url)</label>
            <textarea type="text" name="redirect" class="form-control @error('redirect') is-invalid @enderror" id="formGroupExampleInput2" placeholder="contoh : https://meli.com47648757j-jlsdhlksdf--sdfjlktempedkjdftempe">{{old('redirect')}}</textarea>
            @error('redirect')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
          <div class="mb-3">
            <label for="formGroupExampleInput3" class="form-label">Remark</label>
            <textarea type="text" name="remark" class="form-control @error('remark') is-invalid @enderror" id="formGroupExampleInput3" placeholder="untuk link meeting">{{old('remark')}}</textarea>
            @error('remark')
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