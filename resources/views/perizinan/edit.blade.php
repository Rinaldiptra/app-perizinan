@extends('layouts.app')

@section('content')

<body>
    <div class="container">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <form action="{{route('perizinan.update',$data->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                  <div class="form-group">
                      <label for="title" class="mb-2">Judul</label>
                      <input type="text" class="form-control mb-2" name="judul" value="{{ $data->Judul}}" required>
                  </div>

                  <div class="form-group">
                      <label for="title" class="mb-2">Tanggal Mulai Izin</label>
                      <input type="date" class="form-control mb-2" name="tanggal_mulai_izin" value="{{ $data->tanggal_mulai_izin}}" required>
                  </div>

                  <div class="form-group">
                      <label for="title" class="mb-2">Tanggal Berakhir Izin</label>
                      <input type="date" class="form-control mb-2" name="tanggal_berakhir_izin" value="{{ $data->tanggal_berakhir_izin}}" required>
                  </div>

                  <div class="form-group">
                      <label for="title" class="mb-2">Catatan</label>
                      <input type="text" class="form-control mb-2" name="catatan" value="{{ $data->catatan}}" required>
                  </div>
                
                  <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary">Update</button>
                    <a href="" class="btn btn-md btn-secondary">back</a>
                  </div>
                 
                 </form>
            </div>
        </div>
    </div>
</body>


@endsection


