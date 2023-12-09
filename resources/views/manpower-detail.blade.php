
@extends('layouts/main')

@section('container')
<section class="section profile">
  @if($error)
  <div class="alert alert-danger" role="alert">
    Data gagal disimpan cek kembali data yang sudah anda isi....
  </div>
  @endif

  @if($success)
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Data berhasil disimpan....
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img  src="{{ $foto  }}" onerror="this.onerror=null;this.src='{{ $errorImage }}';" alt="Profile" class="rounded-circle">
            <h2>{{$mpDetail[0]->nama}}</h2>
            <h3>{{ $mpDetail[0]->jabatanFn }}</h3>
            <div class="social-links mt-2">
              <a target="_blank" rel="noopener noreferrer" href="https://wa.me/{{$mpDetail[0]->noTelp1}}" class="twitter" title="Click to whatsapp"><i class="bi bi-whatsapp"></i></a>
            </div>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

              <li class="nav-item" role="presentation">
                <button class="nav-link {{ $tabBtn[0] }}" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">Overview</button>
              </li>

              <li class="nav-item" role="presentation">
                <button class="nav-link {{ $tabBtn[1] }}" data-bs-toggle="tab" data-bs-target="#profile-training" aria-selected="false" role="tab" tabindex="-1">Training</button>
              </li>

              <li class="nav-item" role="presentation">
                <button class="nav-link {{ $tabBtn[2] }}" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" role="tab" tabindex="-1">Edit Profile</button>
              </li>

            </ul>
            <div class="tab-content pt-2" id="detailMp">

  <div class="tab-pane fade profile-overview {{ $tab[0] }}" id="profile-overview" role="tabpanel">
    <h5 class="card-title">About</h5>
    <p class="small fst-italic">{{ $mpDetail[0]->about }}</p>

    <h5 class="card-title">Profile Details</h5>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">Nama Lengkap</div>
      <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->nama }}</div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">NRP</div>
      <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->nrp }}</div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">No. Mine Permit</div>
      <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->noMinePermit }}</div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">Perusahaan</div>
      <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->perusahaan}}</div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">Section</div>
      <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->section }}</div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-4 label">Job Area</div>
      <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->jobArea }}</div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">Sub-Section</div>
      <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->subSection }}</div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">Jabatan(Struktural)</div>
      <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->jabatanStr }}</div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-4 label">Jabatan(Fungsional)</div>
      <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->jabatanFn }}</div>
    </div>

    <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item">
        <div class="accordion-header" id="flush-headingOne">
          <button class="accordion-button collapsed card-title" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
            More Detail
          </button>
        </div>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Grade</div>
              <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->grade }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Specialist</div>
              <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->spesialis }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Joint Date</div>
              <div class="col-lg-9 col-md-8">{{ date_format(date_create($mpDetail[0]->jointDate),"d M Y") }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Joint to Maco</div>
              <div class="col-lg-9 col-md-8">{{ date_format(date_create($mpDetail[0]->jointToMaco),"d M Y") }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Tempat Lahir</div>
              <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->tempatLahir }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Tanggal Lahir</div>
              <div class="col-lg-9 col-md-8">{{ ($mpDetail[0]->tanggalLahir!=null)?date_format(date_create($mpDetail[0]->tanggalLahir),"d M Y") :"-" }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Phone 1</div>
              <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->noTelp1 }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Phone 2</div>
              <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->noTelp2 }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Email</div>
              <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->email }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Status</div>
              <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->status }}</div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-4 label">Remark</div>
              <div class="col-lg-9 col-md-8">{{ $mpDetail[0]->remark }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="tab-pane fade profile-edit {{ $tab[1] }}" id="profile-training" role="tabpanel">
    <table class="table">
      <thead>
        <tr>
          <th>Nama Training</th>
          <th>Lembaga</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($training as $item)
        <tr>
          <td>{{($item=='-')? $item->uraianMateri:$item->judul }}</td>
          <td>{{ $item->lembaga }}</td>
          <td>{{ date_format(date_create($item->start),"d M Y") }}</td>    
      </tr>
        @endforeach
        
    
    </tbody>
    </table>

  </div>

  <div class="tab-pane fade profile-edit {{ $tab[2] }}" id="profile-edit" role="tabpanel">

    <!-- Profile Edit Form -->
    <form method="POST" action="/updateMp" autocomplete="off" enctype="multipart/form-data">
      @csrf
      <div class="row mb-3">
        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
        <div class="col-md-8 col-lg-9">
          <img id="profileImage" src="{{ $foto }}" onerror="this.onerror=null;this.src='{{ $errorImage }}';" alt="Profile">
          <div class="pt-2">
            <button type="button" id="uploadBtn" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></button>
            <button type="button" id="deleteBtn" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></button>
            <input class="@error('file') is-invalid @enderror"  name="file" id="file" type="file" hidden>
            @error('file')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
            <input name="kunam" id="kunam" type="text" hidden>
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
        <div class="col-md-8 col-lg-9">
          <input name="fullName" type="text" class="form-control @error('fullName') is-invalid @enderror" id="fullName" value="@error('fullName') {{ old('fullName') }}@else{{ $mpDetail->first()->nama }}@enderror">
          @error('fullName')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
        <div class="col-md-8 col-lg-9">
          <textarea name="about" class="form-control" id="about" style="height: 100px">{{ $mpDetail->first()->about }}</textarea>
        </div>
      </div>

      <div class="row mb-3">
        <label for="nrp" class="col-md-4 col-lg-3 col-form-label">NRP</label>
        <div class="col-md-8 col-lg-9">
          <input name="nrp" type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" value="@error('nrp') {{ old('nrp') }} @else{{ $mpDetail->first()->nrp }}@enderror">
          <input name="oldNrp" type="hidden" value="{{ $mpDetail->first()->nrp }}">
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
          <input name="noMp" type="text" class="form-control" id="noMp" value="{{ $mpDetail->first()->noMinePermit }}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="pers" class="col-md-4 col-lg-3 col-form-label">Perusahaan</label>
        <div class="col-md-8 col-lg-9">
          <select name="pers" id="pers" class="form-select @error('pers') is-invalid @enderror">
            <option value>Pilih Perusahaan</option>
            @foreach($listPerusahaan as $x)
            @if ($x->id===$mpDetail->first()->idPerusahaan)
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
              @if ($x->section===$mpDetail->first()->section)
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

          <select name="jArea" id="jArea" class="form-select @error('sect') is-invalid @enderror">
            <option value>Pilih Job Area</option>
            @foreach($listJobArea as $x)
              @if ($x->jobArea===$mpDetail->first()->jobArea)
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

          <select name="ssect" id="ssect" class="form-select @error('sect') is-invalid @enderror">
            <option value>Pilih Sub - Section</option>
            @foreach($listSubSection as $x)
              @if ($x->subSection===$mpDetail->first()->subSection)
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

          <select name="jbtStr" id="jbtStr" class="form-select @error('sect') is-invalid @enderror">
            <option value>Pilih Jabatan Struktural</option>
            @foreach($listStruktural as $x)
              @if ($x->jabatanStruktural===$mpDetail->first()->jabatanStr)
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

          <select name="jbtFn" id="jbtFn" class="form-select @error('sect') is-invalid @enderror">
            <option value>Pilih jabatan Fungsional</option>
            @foreach($listFungsional as $x)
              @if ($x->jabatanFungsional===$mpDetail->first()->jabatanFn)
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
          <input name="grade" type="text" class="form-control" id="grade" value="{{ $mpDetail->first()->grade }}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="spcl" class="col-md-4 col-lg-3 col-form-label">Specialist</label>
        <div class="col-md-8 col-lg-9">
          <input name="spcl" type="text" class="form-control" id="spcl" value="{{ $mpDetail->first()->spesialis }}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="jntDt" class="col-md-4 col-lg-3 col-form-label">Joint Date</label>
        <div class="col-md-8 col-lg-9">
          <input name="jntDt" type="date" class="form-control" id="jntDt" value="{{$mpDetail->first()->jointDate }}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="jntMaco" class="col-md-4 col-lg-3 col-form-label">Joint to Maco</label>
        <div class="col-md-8 col-lg-9">
          <input name="jntMaco" type="date" class="form-control" id="jntMaco" value="{{$mpDetail->first()->jointToMaco }}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="tmpLhr" class="col-md-4 col-lg-3 col-form-label">Tempat Lahir</label>
        <div class="col-md-8 col-lg-9">
          <input name="tmpLhr" type="text" class="form-control" id="tmpLhr" value="{{ $mpDetail->first()->tempatLahir }}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="tglLhr" class="col-md-4 col-lg-3 col-form-label">Tanggal Lahir</label>
        <div class="col-md-8 col-lg-9">
          <input name="tglLhr" type="date" class="form-control" id="tglLhr" value="{{ $mpDetail->first()->tanggalLahir }}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="phn1" class="col-md-4 col-lg-3 col-form-label">Phone 1</label>
        <div class="col-md-8 col-lg-9">
          <input name="phn1" type="text" class="form-control" id="phn1" value="{{ $mpDetail->first()->noTelp1 }}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="phn2" class="col-md-4 col-lg-3 col-form-label">Phone 2</label>
        <div class="col-md-8 col-lg-9">
          <input name="phn2" type="text" class="form-control" id="phn2" value="{{ $mpDetail->first()->noTelp2 }}">
        </div>
      </div>

      <div class="row mb-3">
        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
        <div class="col-md-8 col-lg-9">
          <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="email" value="@error('email'){{ old('email') }}@else{{ $mpDetail->first()->email }}@enderror">
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
          <select class="form-control form-select" name="sts" id="sts">
            @foreach ($statusList as $item)
              @if ($mpDetail->first()->status==$item)
                <option value="{{ $item }}" selected>{{ $item }}</option> 
              @else
                <option value="{{ $item }}">{{ $item }}</option>  
              @endif
            @endforeach
          </select>
        </div>
      </div>
      <div class="row mb-3">
        <label for="tglNonActive" class="col-md-4 col-lg-3 col-form-label">Non Active Date</label>
        <div class="col-md-8 col-lg-9">
          <input name="tglNonActive" type="date" class="form-control @error ('tglNonActive') is-invalid @enderror" id="tglNonActive" value="{{ $mpDetail->first()->NotActiveStatus }}">
          @error("tglNonActive")
          <div class="invalid-feedback">
            {{ $message }}
            </div>
            @enderror
        </div>
      </div>


      <div class="row mb-3">
        <label for="rmk" class="col-md-4 col-lg-3 col-form-label">Remark</label>
        <div class="col-md-8 col-lg-9">
          <textarea name="rmk" type="text" class="form-control" id="rmk">{{ $mpDetail->first()->remark }}</textarea>
        </div>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <button data-bs-toggle="modal" data-bs-target="#basicModal" type="button" class="btn btn-danger">Delete</button>
      </div>
    </form><!-- End Profile Edit Form -->
  </div>


</div><!-- End Bordered Tabs -->

            </div>

          </div>
        </div>

      </div>

      {{-- modal delete --}}
      <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Message Warning</h5>
        
            </div>
            <div class="modal-body">
              <h3>Yakin ingin menghapus data ini....??</h3>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
              <a href="/mp-delete?ngok={{$mpDetail->first()->nrp}}" type="button" class="btn btn-danger">Delete</a>
            </div>
          </div>
        </div>
      </div><!-- End Modal Delete-->
  </section>

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
    document.getElementById('kunam').value='';
    cekManpowerStatus(document.getElementById('sts').value);

    $(document).on('change','#sts',function(){
      cekManpowerStatus(document.getElementById('sts').value);
    })
    $(document).on('click','#uploadBtn',function(){
        let fileData=document.getElementById('file');
        $(fileData).click();
      })

      $(document).on('change',file,function(){
        let fileData=document.getElementById('file');
          let x=document.getElementById('profileImage');
          let[a]=fileData.files;
          x.src=(URL.createObjectURL(a));
          document.getElementById('kunam').value='';
      })
      $(document).on('click','#deleteBtn',function(){
        let fileData=document.getElementById('file');
        let x=document.getElementById('profileImage');
        document.getElementById('kunam').value='1';
        fileData.value=null;
        x.src="{{ $errorImage }}";
      })
    
  }) //end of ready function

  function cekManpowerStatus(manpowerStatus){
    if(manpowerStatus!='AKTIF'){
      document.getElementById('tglNonActive').disabled=false;
    }else{
      document.getElementById('tglNonActive').value=null;
      document.getElementById('tglNonActive').disabled=true;
    }
  }
</script>
@endpush
