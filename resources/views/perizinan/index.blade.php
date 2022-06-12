@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Test Perizinan</title>
  </head>
  <body>

  <div class="container-xxl">
          @if($data2 != null)
          <button type="button" class="btn btn-secondary mb-3" disabled>Buat Perizinan</button>
          @else
            <a class="btn btn-success mb-3" href="" data-toggle="modal" data-target="#exampleModal">Buat Perizinan</a>
          @endif

        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        @if (session('error'))
          <div class="alert alert-error">
            {{ session('error') }}
          </div>
        @endif


        <table class="table table-bordered" >
            <thead>
              <tr>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">Judul</th>
                <th scope="col">Tanggal Mulai Perizinan</th>
                <th scope="col">Tanggal Berakhir Perizinan</th>
                <th scope="col">Catatan</th>
                <th scope="col">Total hari</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

              @foreach($data as $data)
                <tr>
                  <td>{{$data->nama}}</td>
                  <td>{{$data->email}}</td>
                  <td>{{$data->Judul}}</td>
                  <td>{{$data->tanggal_mulai_izin}}</td>
                  <td>{{$data->tanggal_berakhir_izin}}</td>
                  <td>{{$data->catatan}}</td>
                  <td>{{$data->total_hari}}</td>
                  <td>
                      @if($data->status == "Perizinan Ditolak")
                        {{$data->status}},[{{$data->catatan_penolakan}}]
                      @else
                        {{$data->status}}
                      @endif

                  </td>
                  <td>
                    @if($data->status == "menunggu persetujuan")
                    <form action="{{ route('perizinan.destroy',$data->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Data akan di hapus');">Delete</button>
                      </form>
                    @elseif($data->status == "Sudah Disetujui")

                    Tidak boleh ada action

                    @else

                    <form action="{{ route('perizinan.destroy',$data->id) }}" method="POST">
                      <a class="btn btn-primary" href="{{ route('perizinan.edit',$data->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Data akan di hapus');">Delete</button>
                      </form>
                      @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
        </table>
  </div>

  <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{route('perizinan.store') }}" method="POST" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="form-group">
                <label for="content">Judul</label>
                <input name="judul" type="text" class="form-control" placeholder="ex: Izin sakit" required>
              </div>

              <div class="form-group">
                <label for="content">Tanggal Mulai Izin</label>
                <input name="tanggal_mulai_izin" type="date" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="content">Tanggal Berakhir Izin</label>
                <input name="tanggal_berakhir_izin" type="date" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="content">Catatan</label>
                <input name="catatan" type="text" class="form-control">
              </div>
               
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light" id="sa-success">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  </body>
</html>

@endsection