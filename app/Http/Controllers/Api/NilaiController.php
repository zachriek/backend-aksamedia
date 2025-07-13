<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function nilaiRT()
    {
        $query = DB::select("
            SELECT 
                n.nama,
                n.nisn,
                SUM(CASE WHEN nama_pelajaran = 'ARTISTIC' THEN n.skor ELSE 0 END) AS artistic,
                SUM(CASE WHEN nama_pelajaran = 'CONVENTIONAL' THEN n.skor ELSE 0 END) AS conventional,
                SUM(CASE WHEN nama_pelajaran = 'ENTERPRISING' THEN n.skor ELSE 0 END) AS enterprising,
                SUM(CASE WHEN nama_pelajaran = 'INVESTIGATIVE' THEN n.skor ELSE 0 END) AS investigative,
                SUM(CASE WHEN nama_pelajaran = 'REALISTIC' THEN n.skor ELSE 0 END) AS realistic,
                SUM(CASE WHEN nama_pelajaran = 'SOCIAL' THEN n.skor ELSE 0 END) AS social
            FROM nilai n
            WHERE 
                n.materi_uji_id = 7
                AND n.nama_pelajaran != 'Pelajaran Khusus'
            GROUP BY n.nama, n.nisn
            ORDER BY n.nama
        ");

        $result = collect($query)->map(function ($item) {
            return [
                'nama' => $item->nama,
                'nisn' => $item->nisn,
                'nilaiRt' => [
                    'artistic' => (int) $item->artistic,
                    'conventional' => (int) $item->conventional,
                    'enterprising' => (int) $item->enterprising,
                    'investigative' => (int) $item->investigative,
                    'realistic' => (int) $item->realistic,
                    'social' => (int) $item->social,
                ]
            ];
        });

        return response()->json($result);
    }

    public function nilaiST()
    {
        $query = DB::select("
            SELECT 
                n.nama,
                n.nisn,
                SUM(CASE WHEN n.pelajaran_id = 44 THEN n.skor * 41.67 ELSE 0 END) AS verbal,
                SUM(CASE WHEN n.pelajaran_id = 45 THEN n.skor * 29.67 ELSE 0 END) AS kuantitatif,
                SUM(CASE WHEN n.pelajaran_id = 46 THEN n.skor * 100   ELSE 0 END) AS penalaran,
                SUM(CASE WHEN n.pelajaran_id = 47 THEN n.skor * 23.81 ELSE 0 END) AS figural,
                (
                    SUM(CASE WHEN n.pelajaran_id = 44 THEN n.skor * 41.67 ELSE 0 END) +
                    SUM(CASE WHEN n.pelajaran_id = 45 THEN n.skor * 29.67 ELSE 0 END) +
                    SUM(CASE WHEN n.pelajaran_id = 46 THEN n.skor * 100   ELSE 0 END) +
                    SUM(CASE WHEN n.pelajaran_id = 47 THEN n.skor * 23.81 ELSE 0 END)
                ) AS total
            FROM nilai n
            WHERE n.materi_uji_id = 4
            AND n.pelajaran_id IN (44, 45, 46, 47)
            GROUP BY n.nama, n.nisn
            ORDER BY total DESC
        ");

        $result = collect($query)->map(function ($item) {
            return [
                'nama' => $item->nama,
                'nisn' => $item->nisn,
                'listNilai' => [
                    'verbal' => round($item->verbal, 2),
                    'kuantitatif' => round($item->kuantitatif, 2),
                    'penalaran' => round($item->penalaran, 2),
                    'figural' => round($item->figural, 2),
                ],
                'total' => round($item->total, 2),
            ];
        });

        return response()->json($result);
    }
}
