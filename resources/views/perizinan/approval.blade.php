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

              @foreach($all as $data)
                <tr>
                  <td>{{$data->nama}}</td>
                  <td>{{$data->email}}</td>
                  <td>{{$data->Judul}}</td>
                  <td>{{$data->tanggal_mulai_izin}}</td>
                  <td>{{$data->tanggal_berakhir_izin}}</td>
                  <td>{{$data->catatan}}</td>
                  <td>{{$data->total_hari}}</td>
                  <td>{{$data->status}}</td>
                  <td>
                    <form action="{{ route('approve',$data->id) }}" method="POST">                                
                      @csrf
                       @method('PUT')
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Data Di setujui');">Setujui</button>
                    </form>
                    <form action="{{ route('tolak',$data->id) }}" method="POST">                                
                        @csrf
                        @method('PUT')
                        <a class="btn btn-danger " href="" data-toggle="modal" data-target="#exampleModal">Tolak</a>
                        <!-- <button type="submit" class="btn btn-danger" onclick="return confirm('Data ini ditolak?');">Tolak</button> -->
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
        </table>
  </div>

    <!-- Modal -->
    @foreach($all as $data)
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
            <form action="{{route('tolak',$data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
              <div class="form-group">
                <label for="content">Catatan Penolakan</label>
                <textarea class="form-control" name="catatan_penolakan" rows="4"></textarea>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="{{ route('tolak',$data->id) }}" method="POST">                                
                    @csrf
                    @method('PUT')     
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Data ini ditolak?');">Tolak</button>
                </form>
                
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach



    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  </body>
</html>

@endsection