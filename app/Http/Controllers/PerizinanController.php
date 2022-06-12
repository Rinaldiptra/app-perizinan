<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perizinan;
use App\Models\HariLibur;
use Auth;
use DateTime;
use DatePeriod;
use DateInterval;

class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Perizinan::where('email', Auth::user()->email)->get();
        $data2 = Perizinan::where('email', Auth::user()->email)->where('status','menunggu persetujuan')->first();
        return view ('perizinan.index',compact('data','data2'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'tanggal_mulai_izin' => 'required',
            'tanggal_berakhir_izin' => 'required'
        ]);
       
        $a = 0;
        $arr = $this->getDatesFromRange($request->tanggal_mulai_izin, $request->tanggal_berakhir_izin);

        foreach ($arr as $key => $value) {
            if (HariLibur::where('tahun-bulan-tanggal', $value)->first() != null) {
                continue;
            }
            if (date('D', strtotime($value)) == "Sun") {
                continue;
            }
            $a++;
        }

        // dd($a);

        $post = Perizinan::create([
            'nama'=>Auth::user()->name,
            'email'=>Auth::user()->email,
            'judul' =>$request->judul,
            'tanggal_mulai_izin' => $request->tanggal_mulai_izin,
            'tanggal_berakhir_izin' => $request->tanggal_berakhir_izin,
            'catatan' => $request->catatan,
            'total_hari' => $a,
            'status'=>'menunggu persetujuan',
        ]);

        if ($post) {
            return redirect()
                ->route('perizinan.index')
                ->with([
                    'success' => 'Permohonan izin berhasil di kirim'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function edit($id)
    {
        $data = Perizinan::findOrFail($id);
        return view('perizinan.edit', compact('data'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required',
            'tanggal_mulai_izin' => 'required',
            'tanggal_berakhir_izin' => 'required'
        ]);

        $a = 0;
        $arr = $this->getDatesFromRange($request->tanggal_mulai_izin, $request->tanggal_berakhir_izin);

        foreach ($arr as $key => $value) {
            if (HariLibur::where('tahun-bulan-tanggal', $value)->first() != null) {
                continue;
            }
            if (date('D', strtotime($value)) == "Sun") {
                continue;
            }
            $a++;
        }

        $data = Perizinan::findOrFail($id);

        $data->update([
            'judul' =>$request->judul,
            'tanggal_mulai_izin' => $request->tanggal_mulai_izin,
            'tanggal_berakhir_izin' => $request->tanggal_berakhir_izin,
            'catatan' => $request->catatan,
            'total_hari' => $a,
            'status'=>'menunggu persetujuan',
        ]);

        if ($data) {
            return redirect()
                ->route('perizinan.index')
                ->with([
                    'success' => 'Perizinan berhasil di update'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem has occured, please try again'
                ]);
        }

    }

    public function destroy($id)
    {
        $data = Perizinan::findOrFail($id);
        $data->delete();

        if ($data) {
            return redirect()
                ->route('perizinan.index')
                ->with([
                    'success' => 'Perizinan berhasil di hapus'
                ]);
        } else {
            return redirect()
                ->route('perizinan.index')
                ->with([
                    'error' => 'Coba lagi, perizinan gagal di hapus'
                ]);
        }
    }

    private function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $array = array();
        $interval = new DateInterval('P1D');
    
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
    
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
    
        foreach($period as $date) { 
            $array[] = $date->format($format); 
        }
    
        return $array;
    }


    public function approval()
    {
        $all = Perizinan::where('status','menunggu persetujuan')->get();
        return view('perizinan.approval',compact('all'));
    } 

    public function approve($id)
    {
        $data = Perizinan::findOrFail($id);
        $data->update([
            'status'=>'Sudah Disetujui',
        ]);
        return redirect('approval');
    }

    public function tolak(Request $request, $id)
    {
        $data = Perizinan::findOrFail($id);

        $data->update([
            'status'=>'Perizinan Ditolak',
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);
        // dd($data);
        if ($data) {
            return redirect()
                ->route('approval')
                ->with([
                    'success' => 'Perizina Ditolak'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem has occured, please try again'
                ]);
        }
    }

    
}
