{{-- @dd($listPerusahaan) --}}
@extends('layouts/main')

@section('container')


    <!-- Profile Edit Form -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">New Manpower</h5>
    <form id="editMp" method="POST" action="mp-new-save" autocomplete="off" enctype="multipart/form-data">
        @csrf
      <div class="row mb-3">
        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
        <div class="col-md-8 col-lg-9">
            <img id="profileImage"  style="height: 10rem" src="" onerror="this.onerror=null;this.src='{{ $foto }}';" alt="Profile">
          <div class="pt-2">
            <button type="button" id="uploadBtn" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></button>
            <button type="button" id="deleteBtn" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></button>
            <input class="@error('file') is-invalid @enderror" name="file" id="file" type="file" hidden>
            @error('file')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
        <div class="col-md-8 col-lg-9">
          <input placeholder="isi dengan menggunkan huruf balok" name="fullName" type="text" class="form-control @error('fullName') is-invalid @enderror" id="fullName" value="{{ old("fullName") }}" list="mpCheck">
          @error('fullName')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div>           
            
        </div>
      </div>

      <div class="row mb-3">
        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
        <div class="col-md-8 col-lg-9">
          <textarea placeholder="contoh: sebelumnya seorang mekanik mesin potong rumput di perusahaan PT. BOTAK JAYA di tahun 1945" name="about" class="form-control" id="about" style="height: 100px"></textarea>
        </div>
      </div>

      <div class="row mb-3">
        <label for="nrp" class="col-md-4 col-lg-3 col-form-label">NRP</label>
        <div class="col-md-8 col-lg-9">
          <input placeholder="isi nama jika non SIS contoh: MELI FERNANDEZZZ" name="nrp" type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" list="datalist" value="{{ old("nrp") }}" >
          @error('nrp')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="noMp" class="col-md-4 col-lg-3 col-form-label">No. Mine Permit</label>
        <div class="col-md-8 col-lg-9">
          <input placeholder="MP/SIS-21220945" name="noMp" type="text" class="form-control" id="noMp">
        </div>
      </div>

      <div class="row mb-3">
        <label for="pers" class="col-md-4 col-lg-3 col-form-label">Perusahaan</label>
        <div class="col-md-8 col-lg-9">
          <select name="pers" id="pers" class="form-select @error('pers') is-invalid @enderror">
            <option value>Pilih Perusahaan</option>
            @foreach($listPerusahaan as $x)
              @if (old('pers')===$x->id)  
              <option value="{{$x->id}}" selected>{{$x->perusahaan}}</option>
              @else
              <option value="{{$x->id}}">{{$x->perusahaan}}</option>
              @endif
            @endforeach
          </select>
          @error('pers')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="sect" class="col-md-4 col-lg-3 col-form-label">Section</label>
        <div class="col-md-8 col-lg-9">
          <select name="sect" id="sect" class="form-select @error('sect') is-invalid @enderror">
            <option value>Pilih Section</option>
            @foreach($listSection as $x)
            @if (old('sect')===$x->section)
            <option value="{{$x->section}}" selected>{{$x->section}}</option>
            @else
            <option value="{{$x->section}}">{{$x->section}}</option>  
            @endif
            @endforeach
          </select>
          @error('sect')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="jArea" class="col-md-4 col-lg-3 col-form-label">Job Area</label>
        <div class="col-md-8 col-lg-9">
        <select name="jArea" id="jArea" class="form-select @error('jArea') is-invalid @enderror">
          <option value>Pilih Job Area</option>
          @foreach($listJobArea as $x)
          @if (old('jArea')===$x->jobArea)
          <option value="{{$x->jobArea}}" selected>{{$x->jobArea}}</option>
          @else
          <option value="{{$x->jobArea}}">{{$x->jobArea}}</option>
          @endif
          @endforeach
        </select>
        @error('jArea')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="ssect" class="col-md-4 col-lg-3 col-form-label">Sub-section</label>
        <div class="col-md-8 col-lg-9">
          <select name="ssect" id="ssect" class="form-select @error('ssect') is-invalid @enderror">
            <option value>Pilih Sub - Section</option>
            @foreach($listSubSection as $x)
            @if (old('ssect')===$x->subSection)  
            <option value="{{$x->subSection}}" selected>{{$x->subSection}}</option>
            @else
            <option value="{{$x->subSection}}">{{$x->subSection}}</option>
            @endif
            @endforeach
          </select>
          @error('ssect')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="jbtStr" class="col-md-4 col-lg-3 col-form-label">Jabatan (Struktural)</label>
        <div class="col-md-8 col-lg-9">
          <select name="jbtStr" id="jbtStr" class="form-select @error('jbtStr') is-invalid @enderror">
            <option value>Pilih Jabatan Struktural</option>
            @foreach($listStruktural as $x)
            @if (old('jbtStr')===$x->jabatanStruktural)
            <option value="{{$x->jabatanStruktural}}" selected>{{$x->jabatanStruktural}}</option>
            @else
            <option value="{{$x->jabatanStruktural}}">{{$x->jabatanStruktural}}</option>
            @endif
            @endforeach
          </select>
          @error('jbtStr')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="jbtFn" class="col-md-4 col-lg-3 col-form-label">Jabatan (Fungsional)</label>
        <div class="col-md-8 col-lg-9">
          <select name="jbtFn" id="jbtFn" class="form-select @error('jbtFn') is-invalid @enderror">
            <option value>Pilih jabatan Fungsional</option>
            @foreach($listFungsional as $x)
            @if (old('jbtFn')===$x->jabatanFungsional)
            <option value="{{$x->jabatanFungsional}}" selected>{{$x->jabatanFungsional}}</option>
            @else
            <option value="{{$x->jabatanFungsional}}">{{$x->jabatanFungsional}}</option>
            @endif
            @endforeach
          </select>
          @error('jbtFn')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="grade" class="col-md-4 col-lg-3 col-form-label">Grade</label>
        <div class="col-md-8 col-lg-9">
          <input name="grade" type="text" class="form-control" id="grade" value="{{old('grade')}}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="spcl" class="col-md-4 col-lg-3 col-form-label">Specialist</label>
        <div class="col-md-8 col-lg-9">
          <input name="spcl" type="text" class="form-control" id="spcl" value="{{old('spcl')}}" >
        </div>
      </div>

      <div class="row mb-3">
        <label for="jntDt" class="col-md-4 col-lg-3 col-form-label">Joint Date</label>
        <div class="col-md-8 col-lg-9">
          <input name="jntDt" type="date" class="form-control" id="jntDt" value="{{old('jntDt')}}">
        </div>
      </div>
      <div class="row mb-3">
        <label for="jntMaco" class="col-md-4 col-lg-3 col-form-label">Joint to Maco</label>
        <div class="col-md-8 col-lg-9">
          <input name="jntMaco" type="date" class="form-control" id="jntMaco" value="{{old('jntMaco')}}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="tmpLhr" class="col-md-4 col-lg-3 col-form-label">Tempat Lahir</label>
        <div class="col-md-8 col-lg-9">
          <input name="tmpLhr" type="text" class="form-control" id="tmpLhr" value="{{old('tmpLhr')}}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="tglLhr" class="col-md-4 col-lg-3 col-form-label">Tanggal Lahir</label>
        <div class="col-md-8 col-lg-9">
          <input name="tglLhr" type="date" class="form-control" id="tglLhr" value="{{old('tglLhr')}}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="phn1" class="col-md-4 col-lg-3 col-form-label">Phone 1</label>
        <div class="col-md-8 col-lg-9">
          <input placeholder="contoh : +62850xxxxxxxx" name="phn1" type="text" class="form-control" id="phn1" value="{{old('phn1')}}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="phn2" class="col-md-4 col-lg-3 col-form-label">Phone 2</label>
        <div class="col-md-8 col-lg-9">
          <input placeholder="contoh : +62850xxxxxxxx" name="phn2" type="text" class="form-control" id="phn2" value="{{old('phn2')}}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
        <div class="col-md-8 col-lg-9">
          <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}">
          @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="sts" class="col-md-4 col-lg-3 col-form-label">Status</label>
        <div class="col-md-8 col-lg-9">
          <select class="form-control form-select" name="sts" id="std">
            @foreach ($statusList as $item)
            @if (old('sts')===$item)
            <option value="{{ $item }}" selected>{{ $item }}</option>  
            @else
            <option value="{{ $item }}">{{ $item }}</option>   
            @endif
            @endforeach
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <label for="rmk" class="col-md-4 col-lg-3 col-form-label">Remark</label>
        <div class="col-md-8 col-lg-9">
          <textarea name="rmk" type="text" class="form-control" id="rmk">{{old('rmk')}}</textarea>
        </div>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form><!-- End Profile Edit Form -->
      </div>
    </div>
  <datalist id="mpCheck">
    @foreach ($listManpower as $item)
        <option>{{$item->nama}} sudah di database</option>
    @endforeach
  </datalist>

@endsection
@push('scripts')
    <script>
    $(document).ready(function(){
      dselect(document.querySelector('#pers'),{search: true});
      dselect(document.querySelector('#sect'),{search: true});
      dselect(document.querySelector('#jArea'),{search: true});
      dselect(document.querySelector('#ssect'),{search: true});
      dselect(document.querySelector('#ssect'),{search: true});
      dselect(document.querySelector('#jbtStr'),{search: true});
      dselect(document.querySelector('#jbtFn'),{search: true});

      $(document).on('click','#uploadBtn',function(){
        let fileData=document.getElementById('file');
        $(fileData).click();
      })

      $(document).on('change',file,function(){
        let fileData=document.getElementById('file');
          let x=document.getElementById('profileImage');
          let[a]=fileData.files;
          x.src=(URL.createObjectURL(a));
      })
      $(document).on('click','#deleteBtn',function(){
        let fileData=document.getElementById('file');
        let x=document.getElementById('profileImage');
        fileData.value=null;
        x.src="{{ $foto }}";
      })     
      
    })

    </script>
    @endpush
    @push('scriptsxx')
      <script>
        
      </script>
    @endpush