<?php

namespace App\Http\Controllers;

use App\Models\LogStokObat;
use App\Models\Obatalkes;
use App\Models\Racikan;
use App\Models\Resep;
use App\Models\ResepDetail;
use App\Models\Signa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ResepController extends Controller
{
    public function index() {
        $reseps = Resep::get();
        $signas = Signa::where('is_deleted', 0)->get();
        $obats  = Obatalkes::where([
            ['is_deleted', 0],
            ['is_active', '=', 1]
        ])->get();

        return Inertia::render('Resep/Index', [
            'reseps' => $reseps,
            'signas' => $signas,
            'obats' => $obats
        ]);
    }

    public function show($id) {
        $resep = Resep::with(['details.obatalkes', 'details.signa', 'racikans.items.obatalkes'])->findOrFail($id);

        return Inertia::render('Resep/Index', [
            'resepDetail' => $resep
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nama_resep' => 'required|string|max:255',

            'non_racikan' => 'nullable|array',
            'non_racikan.*.obatalkes_id' => 'required|integer',
            'non_racikan.*.qty' => 'required|integer|min:1',
            'non_racikan.*.signa_id' => 'required|integer',

            'racikans' => 'nullable|array',
            'racikans.*.nama' => 'required|string|max:255',
            'racikans.*.signa_id' => 'required|integer',
            'racikans.*.items' => 'required|array|min:1',
            'racikans.*.items.*.obatalkes_id' => 'required|integer',
            'racikans.*.items.*.qty' => 'required|integer|min:1',
        ]);

        $hasNonRacikan = isset($data['non_racikan']) && count($data['non_racikan']) > 0;
        $hasRacikanObat = false;

        if (isset($data['racikans']) && count($data['racikans']) > 0) {
            foreach ($data['racikans'] as $racikan) {
                if (isset($racikan['items']) && count($racikan['items']) > 0) {
                    $hasRacikanObat = true;
                    break;
                }
            }
        }

        if (!($hasNonRacikan || $hasRacikanObat)) {
            return back()->withErrors(['error' => 'Pilih salah 1 obat']);
        }
        try {
            DB::beginTransaction();
            $resep = Resep::create([
                'nama_resep' => $data['nama_resep'],
                'created_by' => Auth::id(),
            ]);
            if (isset($data['non_racikan'])) {
                foreach ($data['non_racikan'] as $obat) {
                    ResepDetail::create([
                        'resep_id' => $resep->resep_id,
                        'obatalkes_id' => $obat['obatalkes_id'],
                        'qty' => $obat['qty'],
                        'signa_id' => $obat['signa_id'],
                        'is_racikan' => false
                    ]);

                    $stokObat = Obatalkes::find($obat['obatalkes_id']);
                    if ($stokObat) {
                        $stokObat->stok -= $obat['qty'];
                        $stokObat->save();

                        LogStokObat::create([
                            'obatalkes_id' => $obat['obatalkes_id'],
                            'resep_id' => $resep->resep_id,
                            'qty_keluar' => $obat['qty'],
                            'sisa_stok' => $stokObat->stok
                        ]);
                    }
                }
            }
            if (isset($data['racikans'])) {
                foreach ($data['racikans'] as $racikan) {
                    $racikanId = Racikan::create([
                        'resep_id' => $resep->resep_id,
                        'nama_racikan' => $racikan['nama'],
                        'signa_id' => $racikan['signa_id']
                    ])->racikan_id;

                    foreach ($racikan['items'] as $item) {
                        ResepDetail::create([
                            'resep_id' => $resep->resep_id,
                            'racikan_id' => $racikanId,
                            'obatalkes_id' => $item['obatalkes_id'],
                            'qty' => $item['qty'],
                            'signa_id' => $racikan['signa_id'],
                            'is_racikan' => true
                        ]);

                        $stokObat = Obatalkes::find($item['obatalkes_id']);
                        if ($stokObat) {
                            if ($stokObat->stok < $item['qty']) {
                                throw new \Exception('Stok tidak mencukupi untuk ' . $stokObat->obatalkes_nama);
                            }
                            $stokObat->stok -= $item['qty'];
                            $stokObat->save();
                            LogStokObat::create([
                                'obatalkes_id' => $item['obatalkes_id'],
                                'resep_id' => $resep->resep_id,
                                'qty_keluar' => $item['qty'],
                                'sisa_stok' => $stokObat->stok
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('resep.index')->with('success', 'Resep berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
