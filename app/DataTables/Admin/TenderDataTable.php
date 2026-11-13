<?php

namespace App\DataTables\Admin;

use App\Helpers\Helpers;
use App\Helpers\TableHelper;
use App\Models\Tender;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TenderDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Tender> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'fokusTender'  => 'admin.tender-lpse.fokus',
                    'data'   => $row,
                    'isFokusTender' => Helpers::isUserFokusTender($row)
                ]);
            })
            ->editColumn('lpse.nama_lpse', function ($row) {
                return '<a href="' . $row->lpse->link .'" target="_blank">'. $row->lpse->nama_lpse .'</a>';
            })
            ->editColumn('updated_at', function (Tender $tender) {
                return TableHelper::tanggal($tender->updated_at);
            })
            ->editColumn('hps', function (Tender $tender) {
                return TableHelper::nominal_simple($tender->hps);
            })
            ->editColumn('nama_paket', function (Tender $tender) {
                $anchor = $tender->nama_paket;
                return Helpers::link(route('redirect.tender', [
                    $tender->slug
                ]), $anchor) .'<br><small class="text-muted">'. $tender->kategori .'-'. $tender->metode_pemilihan .'-' . $tender->metode_pengadaan . '-' . $tender->metode_evaluasi . '</small><br><small class="text-muted">Nilai Kontrak :' .$tender->nilai_kontrak. '</small>';
            })
            ->editColumn('tahap_tender', function (Tender $tender) {

                $anchor = '';
                if($tender->tahap_tender == 'Tender Sudah Selesai'){
                    $anchor = '<span class="badge badge-light-danger p-2">' . $tender->tahap_tender . '</span>';
                }else{
                    $anchor = '<span class="badge badge-light-success p-2">' . $tender->tahap_tender . '</span>';
                }
                return Helpers::link(route('redirect.tender.tahapan', [
                    $tender->slug
                ]), $anchor);
            })
            ->rawColumns(['nama_paket','action','tahap_tender', 'checkbox','lpse.nama_lpse'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Tender>
     */
    public function query(Tender $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('tender-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        'bulk-delete' => [
                            'text' => '<i class="fa fa-trash"></i> Bulk Delete', // Button text with optional icon
                            'className' => 'btn btn-danger', // CSS class for styling
                            'action' => 'function(e, dt, node, config) {
                                var selectedIds = [];
                                $(".row-checkbox:checked").each(function() {
                                    selectedIds.push($(this).val());
                                });

                                if (selectedIds.length === 0) {
                                    alert("Please select at least one row to delete.");
                                    return;
                                }

                                if (confirm("Are you sure you want to delete the selected rows?")) {
                                    $.ajax({
                                        url: "' . route('admin.tender-lpse.bulk-delete') . '",
                                        type: "POST",
                                        data: {
                                            ids: selectedIds,
                                            _token: "' . csrf_token() . '"
                                        },
                                        success: function(response) {
                                            dt.ajax.reload(); // Reload the DataTable
                                            alert(response.message);
                                        },
                                        error: function(xhr) {
                                            alert("An error occurred while deleting the rows.");
                                        }
                                    });
                                }
                            }',
                        ],
                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        // Target the "tahap_tender" column (adjust index if needed)
                        var columnIdx = api.column("tahap_tender:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"select2 form-control tahapan_tender\"><option value=\"\">Semua Tahapan</option></select>")
                            // .appendTo($(api.column(columnIdx).header()).empty())
                            .appendTo(".filter2")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnIdx)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        select.append("<option value=\"Download Dokumen Pemilihan\">Download Dokumen Pemilihan</option>");
                        select.append("<option value=\"Evaluasi Administrasi, Kualifikasi, Teknis, dan Harga\">Evaluasi Administrasi, Kualifikasi, Teknis, dan Harga</option>");
                        select.append("<option value=\"Evaluasi Dokumen Kualifikasi\">Evaluasi Dokumen Kualifikasi</option>");
                        select.append("<option value=\"Klarifikasi dan Negosiasi Teknis dan Biaya\">Klarifikasi dan Negosiasi Teknis dan Biaya</option>");
                        select.append("<option value=\"Masa Sanggah\">Masa Sanggah</option>");
                        select.append("<option value=\"Masa Sanggah Prakualifikasi\">Masa Sanggah Prakualifikasi</option>");
                        select.append("<option value=\"Pembukaan dan Evaluasi Penawaran File I: Administrasi dan Teknis\">Pembukaan dan Evaluasi Penawaran File I: Administrasi dan Teknis </option>");
                        select.append("<option value=\"Pembukaan dan Evaluasi Penawaran File I: Administrasi, Dokumen Kualifikasi, dan Teknis\">Pembukaan dan Evaluasi Penawaran File I: Administrasi, Dokumen Kualifikasi, dan Teknis</option>");
                        select.append("<option value=\"Pembukaan dan Evaluasi Penawaran File II: Harga\">Pembukaan dan Evaluasi Penawaran File II: Harga</option>");
                        select.append("<option value=\"Pembukaan Dokumen Penawaran\">Pembukaan Dokumen Penawaran</option>");
                        select.append("<option value=\"Pembuktian Kualifikasi\">Pembuktian Kualifikasi</option>");
                        select.append("<option value=\"Penandatanganan Kontrak\">Penandatanganan Kontrak</option>");
                        select.append("<option value=\"Penetapan Pemenang\">Penetapan Pemenang</option>");
                        select.append("<option value=\"Pengumuman Hasil Evaluasi Administrasi dan Teknis\">Pengumuman Hasil Evaluasi Administrasi dan Teknis</option>");
                        select.append("<option value=\"Pengumuman Pascakualifikasi\">Pengumuman Pascakualifikasi</option>");
                        select.append("<option value=\"Pengumuman Pemenang\">Pengumuman Pemenang</option>");
                        select.append("<option value=\"Pengumuman Prakualifikasi\">Pengumuman Prakualifikasi</option>");
                        select.append("<option value=\"Seleksi Batal\">Seleksi Batal</option>");
                        select.append("<option value=\"Seleksi Gagal\">Seleksi Gagal</option>");
                        select.append("<option value=\"Surat Penunjukan Penyedia Barang/Jasa\">Surat Penunjukan Penyedia Barang/Jasa</option>");
                        select.append("<option value=\"Tender Batal\">Tender Batal</option>");
                        select.append("<option value=\"Tender Gagal\">Tender Gagal</option>");
                        select.append("<option value=\"Tender Sudah Selesai\">Tender Sudah Selesai</option>");
                        select.append("<option value=\"Tidak Ada Jadwal\">Tidak Ada Jadwal</option>");
                        select.append("<option value=\"Upload Dokumen Penawaran\">Upload Dokumen Penawaran</option>");

                        // Filter by LPSE
                        var lpse = api.column("lpse.nama_lpse:name").index();

                        var select1 = $("<select name=\"filter\" id=\"filter\" class=\"select2 klpdi form-control \"><option value=\"\">Semua KLPDI</option></select>")
                            // .appendTo($(api.column(lpse).header()).empty())
                            .appendTo(".filter1")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(lpse)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        select1.append("<option value=\"LPSE Badan Informasi Geospasial\">LPSE Badan Informasi Geospasial</option>");
                        select1.append("<option value=\"LPSE Badan Intelijen Negara\">LPSE Badan Intelijen Negara</option>");
                        select1.append("<option value=\"LPSE Badan Keamanan Laut\">LPSE Badan Keamanan Laut</option>");
                        select1.append("<option value=\"LPSE Badan Kepegawaian Negara\">LPSE Badan Kepegawaian Negara</option>");
                        select1.append("<option value=\"LPSE Badan Koordinasi Penanaman Modal\">LPSE Badan Koordinasi Penanaman Modal</option>");
                        select1.append("<option value=\"LPSE Badan Meteorologi, Klimatologi dan Geofisika\">LPSE Badan Meteorologi, Klimatologi dan Geofisika</option>");
                        select1.append("<option value=\"LPSE Badan Narkotika Nasional\">LPSE Badan Narkotika Nasional</option>");
                        select1.append("<option value=\"LPSE Badan Nasional Penanggulangan Bencana\">LPSE Badan Nasional Penanggulangan Bencana</option>");
                        select1.append("<option value=\"LPSE Badan Nasional Penanggulangan Terorisme\">LPSE Badan Nasional Penanggulangan Terorisme</option>");
                        select1.append("<option value=\"LPSE Badan Nasional Pencarian dan Pertolongan (BASARNAS)\">LPSE Badan Nasional Pencarian dan Pertolongan (BASARNAS)</option>");
                        select1.append("<option value=\"LPSE Badan Pengawas Obat dan Makanan\">LPSE Badan Pengawas Obat dan Makanan</option>");
                        select1.append("<option value=\"LPSE Badan Pengawasan Keuangan dan Pembangunan (BPKP)\">LPSE Badan Pengawasan Keuangan dan Pembangunan (BPKP)</option>");
                        select1.append("<option value=\"LPSE Badan Pengusaha Batam\">LPSE Badan Pengusaha Batam</option>");
                        select1.append("<option value=\"LPSE Badan Perlindungan Pekerja Migran Indonesia\">LPSE Badan Perlindungan Pekerja Migran Indonesia</option>");
                        select1.append("<option value=\"LPSE Badan Pusat Statistik\">LPSE Badan Pusat Statistik</option>");
                        select1.append("<option value=\"LPSE Badan Riset dan Inovasi Nasional\">LPSE Badan Riset dan Inovasi Nasional</option>");
                        select1.append("<option value=\"LPSE Badan Siber dan Sandi Negara\">LPSE Badan Siber dan Sandi Negara</option>");
                        select1.append("<option value=\"LPSE BAPPENAS\">LPSE BAPPENAS</option>");
                        select1.append("<option value=\"LPSE BKKBN\">LPSE BKKBN</option>");
                        select1.append("<option value=\"LPSE Dewan Perwakilan Rakyat Republik Indonesia\">LPSE Dewan Perwakilan Rakyat Republik Indonesia</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Barat\">LPSE Kabupaten Aceh Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Barat Daya\">LPSE Kabupaten Aceh Barat Daya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Besar\">LPSE Kabupaten Aceh Besar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Jaya\">LPSE Kabupaten Aceh Jaya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Selatan\">LPSE Kabupaten Aceh Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Singkil\">LPSE Kabupaten Aceh Singkil</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Tamiang\">LPSE Kabupaten Aceh Tamiang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Tengah\">LPSE Kabupaten Aceh Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Tenggara\">LPSE Kabupaten Aceh Tenggara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Timur\">LPSE Kabupaten Aceh Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Aceh Utara\">LPSE Kabupaten Aceh Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Agam\">LPSE Kabupaten Agam</option>");
                        select1.append("<option value=\"LPSE Kabupaten Alor\">LPSE Kabupaten Alor</option>");
                        select1.append("<option value=\"LPSE Kabupaten Asahan\">LPSE Kabupaten Asahan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Asmat\">LPSE Kabupaten Asmat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Badung\">LPSE Kabupaten Badung</option>");
                        select1.append("<option value=\"LPSE Kabupaten Balangan\">LPSE Kabupaten Balangan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bandung\">LPSE Kabupaten Bandung</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bandung Barat\">LPSE Kabupaten Bandung Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Banggai\">LPSE Kabupaten Banggai</option>");
                        select1.append("<option value=\"LPSE Kabupaten Banggai Kepulauan\">LPSE Kabupaten Banggai Kepulauan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Banggai Laut\">LPSE Kabupaten Banggai Laut</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bangka\">LPSE Kabupaten Bangka</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bangka Barat\">LPSE Kabupaten Bangka Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bangka Selatan\">LPSE Kabupaten Bangka Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bangka Tengah\">LPSE Kabupaten Bangka Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bangkalan\">LPSE Kabupaten Bangkalan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bangli\">LPSE Kabupaten Bangli</option>");
                        select1.append("<option value=\"LPSE Kabupaten Banjar\">LPSE Kabupaten Banjar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Banjarnegara\">LPSE Kabupaten Banjarnegara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bantaeng\">LPSE Kabupaten Bantaeng</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bantul\">LPSE Kabupaten Bantul</option>");
                        select1.append("<option value=\"LPSE Kabupaten Banyuasin\">LPSE Kabupaten Banyuasin</option>");
                        select1.append("<option value=\"LPSE Kabupaten Banyumas\">LPSE Kabupaten Banyumas</option>");
                        select1.append("<option value=\"LPSE Kabupaten Banyuwangi\">LPSE Kabupaten Banyuwangi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Barito Kuala\">LPSE Kabupaten Barito Kuala</option>");
                        select1.append("<option value=\"LPSE Kabupaten Barito Selatan\">LPSE Kabupaten Barito Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Barito Timur\">LPSE Kabupaten Barito Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Barito Utara\">LPSE Kabupaten Barito Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Barru\">LPSE Kabupaten Barru</option>");
                        select1.append("<option value=\"LPSE Kabupaten Batang\">LPSE Kabupaten Batang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Batanghari\">LPSE Kabupaten Batanghari</option>");
                        select1.append("<option value=\"LPSE Kabupaten Batu Bara\">LPSE Kabupaten Batu Bara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bekasi\">LPSE Kabupaten Bekasi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Belitung\">LPSE Kabupaten Belitung</option>");
                        select1.append("<option value=\"LPSE Kabupaten Belitung Timur\">LPSE Kabupaten Belitung Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Belu\">LPSE Kabupaten Belu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bener Meriah\">LPSE Kabupaten Bener Meriah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bengkalis\">LPSE Kabupaten Bengkalis</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bengkayang\">LPSE Kabupaten Bengkayang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bengkulu Selatan\">LPSE Kabupaten Bengkulu Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bengkulu Tengah\">LPSE Kabupaten Bengkulu Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bengkulu Utara\">LPSE Kabupaten Bengkulu Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Berau\">LPSE Kabupaten Berau</option>");
                        select1.append("<option value=\"LPSE Kabupaten Biak Numfor\">LPSE Kabupaten Biak Numfor</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bima\">LPSE Kabupaten Bima</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bintan\">LPSE Kabupaten Bintan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bireuen\">LPSE Kabupaten Bireuen</option>");
                        select1.append("<option value=\"LPSE Kabupaten Blitar\">LPSE Kabupaten Blitar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Blora\">LPSE Kabupaten Blora</option>");
                        select1.append("<option value=\"LPSE Kabupaten Boalemo\">LPSE Kabupaten Boalemo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bogor\">LPSE Kabupaten Bogor</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bojonegoro\">LPSE Kabupaten Bojonegoro</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bolaang Mongondow\">LPSE Kabupaten Bolaang Mongondow</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bolaang Mongondow Selatan\">LPSE Kabupaten Bolaang Mongondow Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bolaang Mongondow Timur\">LPSE Kabupaten Bolaang Mongondow Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bolaang Mongondow Utara\">LPSE Kabupaten Bolaang Mongondow Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bombana\">LPSE Kabupaten Bombana</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bondowoso\">LPSE Kabupaten Bondowoso</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bone\">LPSE Kabupaten Bone</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bone Bolango\">LPSE Kabupaten Bone Bolango</option>");
                        select1.append("<option value=\"LPSE Kabupaten Boven Digoel\">LPSE Kabupaten Boven Digoel</option>");
                        select1.append("<option value=\"LPSE Kabupaten Boyolali\">LPSE Kabupaten Boyolali</option>");
                        select1.append("<option value=\"LPSE Kabupaten Brebes\">LPSE Kabupaten Brebes</option>");
                        select1.append("<option value=\"LPSE Kabupaten Buleleng\">LPSE Kabupaten Buleleng</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bulukumba\">LPSE Kabupaten Bulukumba</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bulungan\">LPSE Kabupaten Bulungan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Bungo\">LPSE Kabupaten Bungo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Buol\">LPSE Kabupaten Buol</option>");
                        select1.append("<option value=\"LPSE Kabupaten Buru\">LPSE Kabupaten Buru</option>");
                        select1.append("<option value=\"LPSE Kabupaten Buru Selatan\">LPSE Kabupaten Buru Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Buton\">LPSE Kabupaten Buton</option>");
                        select1.append("<option value=\"LPSE Kabupaten Buton Selatan\">LPSE Kabupaten Buton Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Buton Tengah\">LPSE Kabupaten Buton Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Buton Utara\">LPSE Kabupaten Buton Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ciamis\">LPSE Kabupaten Ciamis</option>");
                        select1.append("<option value=\"LPSE Kabupaten Cianjur\">LPSE Kabupaten Cianjur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Cilacap\">LPSE Kabupaten Cilacap</option>");
                        select1.append("<option value=\"LPSE Kabupaten Cirebon\">LPSE Kabupaten Cirebon</option>");
                        select1.append("<option value=\"LPSE Kabupaten Dairi\">LPSE Kabupaten Dairi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Deiyai\">LPSE Kabupaten Deiyai</option>");
                        select1.append("<option value=\"LPSE Kabupaten Deli Serdang\">LPSE Kabupaten Deli Serdang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Demak\">LPSE Kabupaten Demak</option>");
                        select1.append("<option value=\"LPSE Kabupaten Dharmasraya\">LPSE Kabupaten Dharmasraya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Dogiyai\">LPSE Kabupaten Dogiyai</option>");
                        select1.append("<option value=\"LPSE Kabupaten Dompu\">LPSE Kabupaten Dompu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Donggala\">LPSE Kabupaten Donggala</option>");
                        select1.append("<option value=\"LPSE Kabupaten Empat Lawang\">LPSE Kabupaten Empat Lawang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ende\">LPSE Kabupaten Ende</option>");
                        select1.append("<option value=\"LPSE Kabupaten Enrekang\">LPSE Kabupaten Enrekang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Fakfak\">LPSE Kabupaten Fakfak</option>");
                        select1.append("<option value=\"LPSE Kabupaten Flores Timur\">LPSE Kabupaten Flores Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Gayo Lues\">LPSE Kabupaten Gayo Lues</option>");
                        select1.append("<option value=\"LPSE Kabupaten Gianyar\">LPSE Kabupaten Gianyar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Gorontalo\">LPSE Kabupaten Gorontalo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Gorontalo Utara\">LPSE Kabupaten Gorontalo Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Gowa\">LPSE Kabupaten Gowa</option>");
                        select1.append("<option value=\"LPSE Kabupaten Gresik\">LPSE Kabupaten Gresik</option>");
                        select1.append("<option value=\"LPSE Kabupaten Grobogan\">LPSE Kabupaten Grobogan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Gunung Mas\">LPSE Kabupaten Gunung Mas</option>");
                        select1.append("<option value=\"LPSE Kabupaten Gunungkidul\">LPSE Kabupaten Gunungkidul</option>");
                        select1.append("<option value=\"LPSE Kabupaten Halmahera Barat\">LPSE Kabupaten Halmahera Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Halmahera Selatan\">LPSE Kabupaten Halmahera Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Halmahera Tengah\">LPSE Kabupaten Halmahera Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Halmahera Timur\">LPSE Kabupaten Halmahera Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Halmahera Utara\">LPSE Kabupaten Halmahera Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Hulu Sungai Selatan\">LPSE Kabupaten Hulu Sungai Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Hulu Sungai Tengah\">LPSE Kabupaten Hulu Sungai Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Hulu Sungai Utara\">LPSE Kabupaten Hulu Sungai Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Humbang Hasundutan\">LPSE Kabupaten Humbang Hasundutan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Indragiri Hilir\">LPSE Kabupaten Indragiri Hilir</option>");
                        select1.append("<option value=\"LPSE Kabupaten Indragiri Hulu\">LPSE Kabupaten Indragiri Hulu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Indramayu\">LPSE Kabupaten Indramayu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Intan Jaya\">LPSE Kabupaten Intan Jaya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Jayapura\">LPSE Kabupaten Jayapura</option>");
                        select1.append("<option value=\"LPSE Kabupaten Jayawijaya\">LPSE Kabupaten Jayawijaya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Jember\">LPSE Kabupaten Jember</option>");
                        select1.append("<option value=\"LPSE Kabupaten Jembrana\">LPSE Kabupaten Jembrana</option>");
                        select1.append("<option value=\"LPSE Kabupaten Jeneponto\">LPSE Kabupaten Jeneponto</option>");
                        select1.append("<option value=\"LPSE Kabupaten Jepara\">LPSE Kabupaten Jepara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Jombang\">LPSE Kabupaten Jombang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kaimana\">LPSE Kabupaten Kaimana</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kampar\">LPSE Kabupaten Kampar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kapuas\">LPSE Kabupaten Kapuas</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kapuas Hulu\">LPSE Kabupaten Kapuas Hulu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Karanganyar\">LPSE Kabupaten Karanganyar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Karangasem\">LPSE Kabupaten Karangasem</option>");
                        select1.append("<option value=\"LPSE Kabupaten Karawang\">LPSE Kabupaten Karawang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Karimun\">LPSE Kabupaten Karimun</option>");
                        select1.append("<option value=\"LPSE Kabupaten Karo\">LPSE Kabupaten Karo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Katingan\">LPSE Kabupaten Katingan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kaur\">LPSE Kabupaten Kaur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kayong Utara\">LPSE Kabupaten Kayong Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kebumen\">LPSE Kabupaten Kebumen</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kediri\">LPSE Kabupaten Kediri</option>");
                        select1.append("<option value=\"LPSE Kabupaten Keerom\">LPSE Kabupaten Keerom</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kendal\">LPSE Kabupaten Kendal</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kepahiang\">LPSE Kabupaten Kepahiang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kepulauan Anambas\">LPSE Kabupaten Kepulauan Anambas</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kepulauan Aru\">LPSE Kabupaten Kepulauan Aru</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kepulauan Mentawai\">LPSE Kabupaten Kepulauan Mentawai</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kepulauan Sangihe\">LPSE Kabupaten Kepulauan Sangihe</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kepulauan Selayar\">LPSE Kabupaten Kepulauan Selayar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kepulauan Yapen\">LPSE Kabupaten Kepulauan Yapen</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kerinci\">LPSE Kabupaten Kerinci</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ketapang\">LPSE Kabupaten Ketapang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Klaten\">LPSE Kabupaten Klaten</option>");
                        select1.append("<option value=\"LPSE Kabupaten Klungkung\">LPSE Kabupaten Klungkung</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kolaka\">LPSE Kabupaten Kolaka</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kolaka Timur\">LPSE Kabupaten Kolaka Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kolaka Utara\">LPSE Kabupaten Kolaka Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Konawe\">LPSE Kabupaten Konawe</option>");
                        select1.append("<option value=\"LPSE Kabupaten Konawe Kepulauan\">LPSE Kabupaten Konawe Kepulauan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Konawe Selatan\">LPSE Kabupaten Konawe Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Konawe Utara\">LPSE Kabupaten Konawe Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kotabaru\">LPSE Kabupaten Kotabaru</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kotawaringin Barat\">LPSE Kabupaten Kotawaringin Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kotawaringin Timur\">LPSE Kabupaten Kotawaringin Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kuantan Singingi\">LPSE Kabupaten Kuantan Singingi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kuburaya\">LPSE Kabupaten Kuburaya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kudus\">LPSE Kabupaten Kudus</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kulon Progo\">LPSE Kabupaten Kulon Progo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kuningan\">LPSE Kabupaten Kuningan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kupang\">LPSE Kabupaten Kupang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kutai Barat\">LPSE Kabupaten Kutai Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kutai Kartanegara\">LPSE Kabupaten Kutai Kartanegara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Kutai Timur\">LPSE Kabupaten Kutai Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Labuhan Batu\">LPSE Kabupaten Labuhan Batu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Labuhan Batu Selatan\">LPSE Kabupaten Labuhan Batu Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Labuhan Batu Utara\">LPSE Kabupaten Labuhan Batu Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lahat\">LPSE Kabupaten Lahat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lamandau\">LPSE Kabupaten Lamandau</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lamongan\">LPSE Kabupaten Lamongan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lampung Barat\">LPSE Kabupaten Lampung Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lampung Tengah\">LPSE Kabupaten Lampung Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lampung Utara\">LPSE Kabupaten Lampung Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Landak\">LPSE Kabupaten Landak</option>");
                        select1.append("<option value=\"LPSE Kabupaten Langkat\">LPSE Kabupaten Langkat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lanny Jaya\">LPSE Kabupaten Lanny Jaya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lebak\">LPSE Kabupaten Lebak</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lebong\">LPSE Kabupaten Lebong</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lembata\">LPSE Kabupaten Lembata</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lima Puluh Kota\">LPSE Kabupaten Lima Puluh Kota</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lingga\">LPSE Kabupaten Lingga</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lombok Barat\">LPSE Kabupaten Lombok Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lombok Tengah\">LPSE Kabupaten Lombok Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lombok Timur\">LPSE Kabupaten Lombok Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lombok Utara\">LPSE Kabupaten Lombok Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Lumajang\">LPSE Kabupaten Lumajang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Luwu\">LPSE Kabupaten Luwu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Luwu Timur\">LPSE Kabupaten Luwu Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Luwu Utara\">LPSE Kabupaten Luwu Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Madiun\">LPSE Kabupaten Madiun</option>");
                        select1.append("<option value=\"LPSE Kabupaten Magelang\">LPSE Kabupaten Magelang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Magetan\">LPSE Kabupaten Magetan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mahakam Ulu\">LPSE Kabupaten Mahakam Ulu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Majalengka\">LPSE Kabupaten Majalengka</option>");
                        select1.append("<option value=\"LPSE Kabupaten Majene\">LPSE Kabupaten Majene</option>");
                        select1.append("<option value=\"LPSE Kabupaten Malaka\">LPSE Kabupaten Malaka</option>");
                        select1.append("<option value=\"LPSE Kabupaten Malang\">LPSE Kabupaten Malang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Malinau\">LPSE Kabupaten Malinau</option>");
                        select1.append("<option value=\"LPSE Kabupaten Maluku Barat Daya\">LPSE Kabupaten Maluku Barat Daya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Maluku Tengah\">LPSE Kabupaten Maluku Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Maluku Tenggara\">LPSE Kabupaten Maluku Tenggara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Maluku Tenggara Barat\">LPSE Kabupaten Maluku Tenggara Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mamasa\">LPSE Kabupaten Mamasa</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mamberamo Raya\">LPSE Kabupaten Mamberamo Raya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mamberamo Tengah\">LPSE Kabupaten Mamberamo Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mamuju\">LPSE Kabupaten Mamuju</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mamuju Tengah\">LPSE Kabupaten Mamuju Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mandailing Natal\">LPSE Kabupaten Mandailing Natal</option>");
                        select1.append("<option value=\"LPSE Kabupaten Manggarai\">LPSE Kabupaten Manggarai</option>");
                        select1.append("<option value=\"LPSE Kabupaten Manggarai Barat\">LPSE Kabupaten Manggarai Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Manggarai Timur\">LPSE Kabupaten Manggarai Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Manokwari\">LPSE Kabupaten Manokwari</option>");
                        select1.append("<option value=\"LPSE KABUPATEN Manokwari Selatan\">LPSE KABUPATEN Manokwari Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mappi\">LPSE Kabupaten Mappi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Maros\">LPSE Kabupaten Maros</option>");
                        select1.append("<option value=\"LPSE Kabupaten Melawi\">LPSE Kabupaten Melawi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mempawah\">LPSE Kabupaten Mempawah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Merangin\">LPSE Kabupaten Merangin</option>");
                        select1.append("<option value=\"LPSE Kabupaten Meranti\">LPSE Kabupaten Meranti</option>");
                        select1.append("<option value=\"LPSE Kabupaten Merauke\">LPSE Kabupaten Merauke</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mesuji\">LPSE Kabupaten Mesuji</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mimika\">LPSE Kabupaten Mimika</option>");
                        select1.append("<option value=\"LPSE Kabupaten Minahasa\">LPSE Kabupaten Minahasa</option>");
                        select1.append("<option value=\"LPSE Kabupaten Minahasa Selatan\">LPSE Kabupaten Minahasa Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Minahasa Tenggara\">LPSE Kabupaten Minahasa Tenggara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Minahasa Utara\">LPSE Kabupaten Minahasa Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Mojokerto\">LPSE Kabupaten Mojokerto</option>");
                        select1.append("<option value=\"LPSE Kabupaten Morowali\">LPSE Kabupaten Morowali</option>");
                        select1.append("<option value=\"LPSE Kabupaten Morowali Utara\">LPSE Kabupaten Morowali Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Muara Enim\">LPSE Kabupaten Muara Enim</option>");
                        select1.append("<option value=\"LPSE Kabupaten Muaro Jambi\">LPSE Kabupaten Muaro Jambi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Muko Muko\">LPSE Kabupaten Muko Muko</option>");
                        select1.append("<option value=\"LPSE Kabupaten Muna\">LPSE Kabupaten Muna</option>");
                        select1.append("<option value=\"LPSE Kabupaten Muna Barat\">LPSE Kabupaten Muna Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Murung Raya\">LPSE Kabupaten Murung Raya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Musi Banyuasin\">LPSE Kabupaten Musi Banyuasin</option>");
                        select1.append("<option value=\"LPSE Kabupaten Musi Rawas\">LPSE Kabupaten Musi Rawas</option>");
                        select1.append("<option value=\"LPSE Kabupaten Musi Rawas Utara\">LPSE Kabupaten Musi Rawas Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Nabire\">LPSE Kabupaten Nabire</option>");
                        select1.append("<option value=\"LPSE Kabupaten Nagan Raya\">LPSE Kabupaten Nagan Raya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Nagekeo\">LPSE Kabupaten Nagekeo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Natuna\">LPSE Kabupaten Natuna</option>");
                        select1.append("<option value=\"LPSE Kabupaten NDuga\">LPSE Kabupaten NDuga</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ngada\">LPSE Kabupaten Ngada</option>");
                        select1.append("<option value=\"LPSE Kabupaten Nganjuk\">LPSE Kabupaten Nganjuk</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ngawi\">LPSE Kabupaten Ngawi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Nias\">LPSE Kabupaten Nias</option>");
                        select1.append("<option value=\"LPSE Kabupaten Nias Barat\">LPSE Kabupaten Nias Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Nias Selatan\">LPSE Kabupaten Nias Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Nias Utara\">LPSE Kabupaten Nias Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Nunukan\">LPSE Kabupaten Nunukan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ogan Ilir\">LPSE Kabupaten Ogan Ilir</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ogan Komering Ilir\">LPSE Kabupaten Ogan Komering Ilir</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ogan Komering Ulu\">LPSE Kabupaten Ogan Komering Ulu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ogan Komering Ulu Selatan\">LPSE Kabupaten Ogan Komering Ulu Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ogan Komering Ulu Timur\">LPSE Kabupaten Ogan Komering Ulu Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pacitan\">LPSE Kabupaten Pacitan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Padang Lawas\">LPSE Kabupaten Padang Lawas</option>");
                        select1.append("<option value=\"LPSE Kabupaten Padang Lawas Utara\">LPSE Kabupaten Padang Lawas Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Padang Pariaman\">LPSE Kabupaten Padang Pariaman</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pakpak Bharat\">LPSE Kabupaten Pakpak Bharat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pamekasan\">LPSE Kabupaten Pamekasan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pandeglang\">LPSE Kabupaten Pandeglang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pangkajene dan Kepulauan\">LPSE Kabupaten Pangkajene dan Kepulauan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Paniai\">LPSE Kabupaten Paniai</option>");
                        select1.append("<option value=\"LPSE Kabupaten Parigi Moutong\">LPSE Kabupaten Parigi Moutong</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pasaman\">LPSE Kabupaten Pasaman</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pasaman Barat\">LPSE Kabupaten Pasaman Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pasangkayu\">LPSE Kabupaten Pasangkayu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Paser\">LPSE Kabupaten Paser</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pasuruan\">LPSE Kabupaten Pasuruan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pati\">LPSE Kabupaten Pati</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pegunungan Arfak\">LPSE Kabupaten Pegunungan Arfak</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pegunungan Bintang\">LPSE Kabupaten Pegunungan Bintang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pekalongan\">LPSE Kabupaten Pekalongan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pelalawan\">LPSE Kabupaten Pelalawan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pemalang\">LPSE Kabupaten Pemalang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Penajam Paser Utara\">LPSE Kabupaten Penajam Paser Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Penukal Abab Lematang Ilir\">LPSE Kabupaten Penukal Abab Lematang Ilir</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pesawaran\">LPSE Kabupaten Pesawaran</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pesisir Barat\">LPSE Kabupaten Pesisir Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pesisir Selatan\">LPSE Kabupaten Pesisir Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pidie\">LPSE Kabupaten Pidie</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pidie Jaya\">LPSE Kabupaten Pidie Jaya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pinrang\">LPSE Kabupaten Pinrang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pohuwato\">LPSE Kabupaten Pohuwato</option>");
                        select1.append("<option value=\"LPSE Kabupaten Polewali Mandar\">LPSE Kabupaten Polewali Mandar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Ponorogo\">LPSE Kabupaten Ponorogo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Poso\">LPSE Kabupaten Poso</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pringsewu\">LPSE Kabupaten Pringsewu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Probolinggo\">LPSE Kabupaten Probolinggo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pulang Pisau\">LPSE Kabupaten Pulang Pisau</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pulau Morotai\">LPSE Kabupaten Pulau Morotai</option>");
                        select1.append("<option value=\"LPSE Kabupaten Pulau Taliabu\">LPSE Kabupaten Pulau Taliabu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Puncak\">LPSE Kabupaten Puncak</option>");
                        select1.append("<option value=\"LPSE Kabupaten Puncak Jaya\">LPSE Kabupaten Puncak Jaya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Purbalingga\">LPSE Kabupaten Purbalingga</option>");
                        select1.append("<option value=\"LPSE Kabupaten Purwakarta\">LPSE Kabupaten Purwakarta</option>");
                        select1.append("<option value=\"LPSE Kabupaten Purworejo\">LPSE Kabupaten Purworejo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Raja Ampat\">LPSE Kabupaten Raja Ampat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Rejang Lebong\">LPSE Kabupaten Rejang Lebong</option>");
                        select1.append("<option value=\"LPSE Kabupaten Rembang (Sekretariat Daerah Kabupaten Rembang Bagian Pengadaan Barang/Jasa)\">LPSE Kabupaten Rembang (Sekretariat Daerah Kabupaten Rembang Bagian Pengadaan Barang/Jasa)</option>");
                        select1.append("<option value=\"LPSE Kabupaten Rokan Hilir\">LPSE Kabupaten Rokan Hilir</option>");
                        select1.append("<option value=\"LPSE Kabupaten Rokan Hulu\">LPSE Kabupaten Rokan Hulu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Rote Ndao\">LPSE Kabupaten Rote Ndao</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sabu Raijua\">LPSE Kabupaten Sabu Raijua</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sambas\">LPSE Kabupaten Sambas</option>");
                        select1.append("<option value=\"LPSE Kabupaten Samosir\">LPSE Kabupaten Samosir</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sampang\">LPSE Kabupaten Sampang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sanggau\">LPSE Kabupaten Sanggau</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sarmi\">LPSE Kabupaten Sarmi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sarolangun\">LPSE Kabupaten Sarolangun</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sekadau\">LPSE Kabupaten Sekadau</option>");
                        select1.append("<option value=\"LPSE Kabupaten Seluma\">LPSE Kabupaten Seluma</option>");
                        select1.append("<option value=\"LPSE Kabupaten Semarang\">LPSE Kabupaten Semarang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Seram Bagian Barat\">LPSE Kabupaten Seram Bagian Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Seram Bagian Timur\">LPSE Kabupaten Seram Bagian Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Serang\">LPSE Kabupaten Serang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Serdang Bedagai\">LPSE Kabupaten Serdang Bedagai</option>");
                        select1.append("<option value=\"LPSE Kabupaten Seruyan\">LPSE Kabupaten Seruyan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Siak\">LPSE Kabupaten Siak</option>");
                        select1.append("<option value=\"LPSE Kabupaten Siau Tagulandang Biaro\">LPSE Kabupaten Siau Tagulandang Biaro</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sidenreng Rappang\">LPSE Kabupaten Sidenreng Rappang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sidoarjo\">LPSE Kabupaten Sidoarjo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sigi\">LPSE Kabupaten Sigi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sijunjung\">LPSE Kabupaten Sijunjung</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sikka\">LPSE Kabupaten Sikka</option>");
                        select1.append("<option value=\"LPSE Kabupaten Simalungun\">LPSE Kabupaten Simalungun</option>");
                        select1.append("<option value=\"LPSE Kabupaten Simeulue\">LPSE Kabupaten Simeulue</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sinjai\">LPSE Kabupaten Sinjai</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sintang\">LPSE Kabupaten Sintang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Situbondo\">LPSE Kabupaten Situbondo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sleman\">LPSE Kabupaten Sleman</option>");
                        select1.append("<option value=\"LPSE Kabupaten Solok\">LPSE Kabupaten Solok</option>");
                        select1.append("<option value=\"LPSE Kabupaten Solok Selatan\">LPSE Kabupaten Solok Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Soppeng\">LPSE Kabupaten Soppeng</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sorong\">LPSE Kabupaten Sorong</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sorong Selatan\">LPSE Kabupaten Sorong Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sragen\">LPSE Kabupaten Sragen</option>");
                        select1.append("<option value=\"LPSE Kabupaten Subang\">LPSE Kabupaten Subang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sukabumi\">LPSE Kabupaten Sukabumi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sukamara\">LPSE Kabupaten Sukamara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sukoharjo\">LPSE Kabupaten Sukoharjo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sula\">LPSE Kabupaten Sula</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sumba Barat\">LPSE Kabupaten Sumba Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sumba Barat Daya\">LPSE Kabupaten Sumba Barat Daya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sumba Tengah\">LPSE Kabupaten Sumba Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sumba Timur\">LPSE Kabupaten Sumba Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sumbawa\">LPSE Kabupaten Sumbawa</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sumbawa Barat\">LPSE Kabupaten Sumbawa Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sumedang\">LPSE Kabupaten Sumedang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Sumenep\">LPSE Kabupaten Sumenep</option>");
                        select1.append("<option value=\"LPSE Kabupaten Supiori\">LPSE Kabupaten Supiori</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tabalong\">LPSE Kabupaten Tabalong</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tabanan\">LPSE Kabupaten Tabanan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Takalar\">LPSE Kabupaten Takalar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Talaud\">LPSE Kabupaten Talaud</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tambrauw\">LPSE Kabupaten Tambrauw</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tana Tidung\">LPSE Kabupaten Tana Tidung</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tana Toraja\">LPSE Kabupaten Tana Toraja</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tanah Bumbu\">LPSE Kabupaten Tanah Bumbu</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tanah Datar\">LPSE Kabupaten Tanah Datar</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tanah Laut\">LPSE Kabupaten Tanah Laut</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tangerang\">LPSE Kabupaten Tangerang</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tanggamus\">LPSE Kabupaten Tanggamus</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tanjung Jabung Barat\">LPSE Kabupaten Tanjung Jabung Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tanjung Jabung Timur\">LPSE Kabupaten Tanjung Jabung Timur</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tapanuli Selatan\">LPSE Kabupaten Tapanuli Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tapanuli Tengah\">LPSE Kabupaten Tapanuli Tengah</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tapanuli Utara\">LPSE Kabupaten Tapanuli Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tapin\">LPSE Kabupaten Tapin</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tasikmalaya\">LPSE Kabupaten Tasikmalaya</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tebo\">LPSE Kabupaten Tebo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tegal\">LPSE Kabupaten Tegal</option>");
                        select1.append("<option value=\"LPSE Kabupaten Teluk Bintuni\">LPSE Kabupaten Teluk Bintuni</option>");
                        select1.append("<option value=\"LPSE Kabupaten Teluk Wondama\">LPSE Kabupaten Teluk Wondama</option>");
                        select1.append("<option value=\"LPSE Kabupaten Temanggung\">LPSE Kabupaten Temanggung</option>");
                        select1.append("<option value=\"LPSE Kabupaten Timor Tengah Selatan\">LPSE Kabupaten Timor Tengah Selatan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Timor Tengah Utara\">LPSE Kabupaten Timor Tengah Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Toba\">LPSE Kabupaten Toba</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tojo una-una\">LPSE Kabupaten Tojo una-una</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tolikara\">LPSE Kabupaten Tolikara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tolitoli\">LPSE Kabupaten Tolitoli</option>");
                        select1.append("<option value=\"LPSE Kabupaten Toraja Utara\">LPSE Kabupaten Toraja Utara</option>");
                        select1.append("<option value=\"LPSE Kabupaten Trenggalek\">LPSE Kabupaten Trenggalek</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tuban\">LPSE Kabupaten Tuban</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tulang Bawang Barat\">LPSE Kabupaten Tulang Bawang Barat</option>");
                        select1.append("<option value=\"LPSE Kabupaten Tulungagung\">LPSE Kabupaten Tulungagung</option>");
                        select1.append("<option value=\"LPSE Kabupaten Wajo\">LPSE Kabupaten Wajo</option>");
                        select1.append("<option value=\"LPSE Kabupaten Wakatobi\">LPSE Kabupaten Wakatobi</option>");
                        select1.append("<option value=\"LPSE Kabupaten Way Kanan\">LPSE Kabupaten Way Kanan</option>");
                        select1.append("<option value=\"LPSE Kabupaten Wonogiri\">LPSE Kabupaten Wonogiri</option>");
                        select1.append("<option value=\"LPSE Kabupaten Wonosobo\">LPSE Kabupaten Wonosobo</option>");
                        select1.append("<option value=\"LPSE KABUPATEN YAHUKIMO\">LPSE KABUPATEN YAHUKIMO</option>");
                        select1.append("<option value=\"LPSE Kejaksaan Agung Republik Indonesia\">LPSE Kejaksaan Agung Republik Indonesia</option>");
                        select1.append("<option value=\"LPSE Kementerian Agama\">LPSE Kementerian Agama</option>");
                        select1.append("<option value=\"LPSE Kementerian Agraria dan Tata Ruang/BPN\">LPSE Kementerian Agraria dan Tata Ruang/BPN</option>");
                        select1.append("<option value=\"LPSE Kementerian Dalam Negeri\">LPSE Kementerian Dalam Negeri</option>");
                        select1.append("<option value=\"LPSE Kementerian Desa, Pembangunan Daerah Tertinggal Dan Transmigrasi\">LPSE Kementerian Desa, Pembangunan Daerah Tertinggal Dan Transmigrasi</option>");
                        select1.append("<option value=\"LPSE Kementerian Energi dan Sumber Daya Mineral\">LPSE Kementerian Energi dan Sumber Daya Mineral</option>");
                        select1.append("<option value=\"LPSE Kementerian Hukum dan HAM RI\">LPSE Kementerian Hukum dan HAM RI</option>");
                        select1.append("<option value=\"LPSE Kementerian Kelautan dan Perikanan\">LPSE Kementerian Kelautan dan Perikanan</option>");
                        select1.append("<option value=\"LPSE Kementerian Ketenagakerjaan\">LPSE Kementerian Ketenagakerjaan</option>");
                        select1.append("<option value=\"LPSE Kementerian Keuangan\">LPSE Kementerian Keuangan</option>");
                        select1.append("<option value=\"LPSE Kementerian Komunikasi dan Informatika\">LPSE Kementerian Komunikasi dan Informatika</option>");
                        select1.append("<option value=\"LPSE Kementerian Koordinator Bidang Politik, Hukum, dan Keamanan\">LPSE Kementerian Koordinator Bidang Politik, Hukum, dan Keamanan</option>");
                        select1.append("<option value=\"LPSE Kementerian Koperasi dan UKM\">LPSE Kementerian Koperasi dan UKM</option>");
                        select1.append("<option value=\"LPSE Kementerian Lingkungan Hidup\">LPSE Kementerian Lingkungan Hidup</option>");
                        select1.append("<option value=\"LPSE Kementerian Lingkungan Hidup dan Kehutanan\">LPSE Kementerian Lingkungan Hidup dan Kehutanan</option>");
                        select1.append("<option value=\"LPSE Kementerian Luar Negeri\">LPSE Kementerian Luar Negeri</option>");
                        select1.append("<option value=\"LPSE Kementerian Pariwisata dan Ekonomi Kreatif/Badan Pariwisata dan Ekonomi Kreatif\">LPSE Kementerian Pariwisata dan Ekonomi Kreatif/Badan Pariwisata dan Ekonomi Kreatif</option>");
                        select1.append("<option value=\"LPSE Kementerian Pekerjaan Umum dan Perumahan Rakyat\">LPSE Kementerian Pekerjaan Umum dan Perumahan Rakyat</option>");
                        select1.append("<option value=\"LPSE Kementerian Pemuda dan Olahraga\">LPSE Kementerian Pemuda dan Olahraga</option>");
                        select1.append("<option value=\"LPSE Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi\">LPSE Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi</option>");
                        select1.append("<option value=\"LPSE Kementerian Perdagangan RI\">LPSE Kementerian Perdagangan RI</option>");
                        select1.append("<option value=\"LPSE Kementerian Perhubungan\">LPSE Kementerian Perhubungan</option>");
                        select1.append("<option value=\"LPSE Kementerian Perindustrian\">LPSE Kementerian Perindustrian</option>");
                        select1.append("<option value=\"LPSE Kementerian Pertahanan Republik Indonesia\">LPSE Kementerian Pertahanan Republik Indonesia</option>");
                        select1.append("<option value=\"LPSE Kementerian Pertanian\">LPSE Kementerian Pertanian</option>");
                        select1.append("<option value=\"LPSE Kementerian Sosial\">LPSE Kementerian Sosial</option>");
                        select1.append("<option value=\"LPSE Kementrian Kesehatan Republik Indonesia\">LPSE Kementrian Kesehatan Republik Indonesia</option>");
                        select1.append("<option value=\"LPSE Kepolisian Republik Indonesia\">LPSE Kepolisian Republik Indonesia</option>");
                        select1.append("<option value=\"LPSE Komisi Pemilihan Umum\">LPSE Komisi Pemilihan Umum</option>");
                        select1.append("<option value=\"LPSE Kota Ambon\">LPSE Kota Ambon</option>");
                        select1.append("<option value=\"LPSE Kota Balikpapan\">LPSE Kota Balikpapan</option>");
                        select1.append("<option value=\"LPSE Kota Banda Aceh\">LPSE Kota Banda Aceh</option>");
                        select1.append("<option value=\"LPSE Kota Bandar Lampung\">LPSE Kota Bandar Lampung</option>");
                        select1.append("<option value=\"LPSE Kota Bandung\">LPSE Kota Bandung</option>");
                        select1.append("<option value=\"LPSE Kota Banjar\">LPSE Kota Banjar</option>");
                        select1.append("<option value=\"LPSE Kota Banjarbaru\">LPSE Kota Banjarbaru</option>");
                        select1.append("<option value=\"LPSE Kota Banjarmasin\">LPSE Kota Banjarmasin</option>");
                        select1.append("<option value=\"LPSE Kota Batam\">LPSE Kota Batam</option>");
                        select1.append("<option value=\"LPSE Kota Batu\">LPSE Kota Batu</option>");
                        select1.append("<option value=\"LPSE Kota Baubau\">LPSE Kota Baubau</option>");
                        select1.append("<option value=\"LPSE Kota Bekasi\">LPSE Kota Bekasi</option>");
                        select1.append("<option value=\"LPSE Kota Bengkulu\">LPSE Kota Bengkulu</option>");
                        select1.append("<option value=\"LPSE Kota Bima\">LPSE Kota Bima</option>");
                        select1.append("<option value=\"LPSE Kota Binjai\">LPSE Kota Binjai</option>");
                        select1.append("<option value=\"LPSE Kota Bitung\">LPSE Kota Bitung</option>");
                        select1.append("<option value=\"LPSE Kota Blitar\">LPSE Kota Blitar</option>");
                        select1.append("<option value=\"LPSE Kota Bogor\">LPSE Kota Bogor</option>");
                        select1.append("<option value=\"LPSE Kota Bontang\">LPSE Kota Bontang</option>");
                        select1.append("<option value=\"LPSE Kota Bukittinggi\">LPSE Kota Bukittinggi</option>");
                        select1.append("<option value=\"LPSE Kota Cilegon\">LPSE Kota Cilegon</option>");
                        select1.append("<option value=\"LPSE Kota Cimahi\">LPSE Kota Cimahi</option>");
                        select1.append("<option value=\"LPSE Kota Denpasar\">LPSE Kota Denpasar</option>");
                        select1.append("<option value=\"LPSE Kota Depok\">LPSE Kota Depok</option>");
                        select1.append("<option value=\"LPSE Kota Dumai\">LPSE Kota Dumai</option>");
                        select1.append("<option value=\"LPSE Kota Gorontalo\">LPSE Kota Gorontalo</option>");
                        select1.append("<option value=\"LPSE Kota Gunungsitoli\">LPSE Kota Gunungsitoli</option>");
                        select1.append("<option value=\"LPSE Kota Jambi\">LPSE Kota Jambi</option>");
                        select1.append("<option value=\"LPSE Kota Jayapura\">LPSE Kota Jayapura</option>");
                        select1.append("<option value=\"LPSE Kota Kediri\">LPSE Kota Kediri</option>");
                        select1.append("<option value=\"LPSE Kota Kendari\">LPSE Kota Kendari</option>");
                        select1.append("<option value=\"LPSE Kota Kotamobagu\">LPSE Kota Kotamobagu</option>");
                        select1.append("<option value=\"LPSE Kota Kupang\">LPSE Kota Kupang</option>");
                        select1.append("<option value=\"LPSE Kota Langsa\">LPSE Kota Langsa</option>");
                        select1.append("<option value=\"LPSE Kota Lhokseumawe\">LPSE Kota Lhokseumawe</option>");
                        select1.append("<option value=\"LPSE Kota Lubuklinggau\">LPSE Kota Lubuklinggau</option>");
                        select1.append("<option value=\"LPSE Kota Madiun\">LPSE Kota Madiun</option>");
                        select1.append("<option value=\"LPSE Kota Magelang\">LPSE Kota Magelang</option>");
                        select1.append("<option value=\"LPSE Kota Makassar\">LPSE Kota Makassar</option>");
                        select1.append("<option value=\"LPSE Kota Malang\">LPSE Kota Malang</option>");
                        select1.append("<option value=\"LPSE Kota Manado\">LPSE Kota Manado</option>");
                        select1.append("<option value=\"LPSE Kota Mataram\">LPSE Kota Mataram</option>");
                        select1.append("<option value=\"LPSE Kota Medan\">LPSE Kota Medan</option>");
                        select1.append("<option value=\"LPSE Kota Metro\">LPSE Kota Metro</option>");
                        select1.append("<option value=\"LPSE Kota Mojokerto\">LPSE Kota Mojokerto</option>");
                        select1.append("<option value=\"LPSE Kota Padang\">LPSE Kota Padang</option>");
                        select1.append("<option value=\"LPSE Kota Padang Panjang\">LPSE Kota Padang Panjang</option>");
                        select1.append("<option value=\"LPSE Kota Padang Sidempuan\">LPSE Kota Padang Sidempuan</option>");
                        select1.append("<option value=\"LPSE Kota Pagar Alam\">LPSE Kota Pagar Alam</option>");
                        select1.append("<option value=\"LPSE Kota Palangkaraya\">LPSE Kota Palangkaraya</option>");
                        select1.append("<option value=\"LPSE Kota Palembang\">LPSE Kota Palembang</option>");
                        select1.append("<option value=\"LPSE Kota Palopo\">LPSE Kota Palopo</option>");
                        select1.append("<option value=\"LPSE Kota Palu\">LPSE Kota Palu</option>");
                        select1.append("<option value=\"LPSE Kota Pangkal Pinang\">LPSE Kota Pangkal Pinang</option>");
                        select1.append("<option value=\"LPSE Kota Parepare\">LPSE Kota Parepare</option>");
                        select1.append("<option value=\"LPSE Kota Pariaman\">LPSE Kota Pariaman</option>");
                        select1.append("<option value=\"LPSE Kota Pasuruan\">LPSE Kota Pasuruan</option>");
                        select1.append("<option value=\"LPSE Kota Payakumbuh\">LPSE Kota Payakumbuh</option>");
                        select1.append("<option value=\"LPSE Kota Pekalongan\">LPSE Kota Pekalongan</option>");
                        select1.append("<option value=\"LPSE Kota Pekanbaru\">LPSE Kota Pekanbaru</option>");
                        select1.append("<option value=\"LPSE Kota Pematangsiantar\">LPSE Kota Pematangsiantar</option>");
                        select1.append("<option value=\"LPSE Kota Pontianak\">LPSE Kota Pontianak</option>");
                        select1.append("<option value=\"LPSE Kota Prabumulih\">LPSE Kota Prabumulih</option>");
                        select1.append("<option value=\"LPSE Kota Probolinggo\">LPSE Kota Probolinggo</option>");
                        select1.append("<option value=\"LPSE Kota Sabang\">LPSE Kota Sabang</option>");
                        select1.append("<option value=\"LPSE Kota Salatiga\">LPSE Kota Salatiga</option>");
                        select1.append("<option value=\"LPSE Kota Samarinda\">LPSE Kota Samarinda</option>");
                        select1.append("<option value=\"LPSE Kota Sawahlunto\">LPSE Kota Sawahlunto</option>");
                        select1.append("<option value=\"LPSE Kota Semarang\">LPSE Kota Semarang</option>");
                        select1.append("<option value=\"LPSE Kota Serang\">LPSE Kota Serang</option>");
                        select1.append("<option value=\"LPSE Kota Sibolga\">LPSE Kota Sibolga</option>");
                        select1.append("<option value=\"LPSE Kota Singkawang\">LPSE Kota Singkawang</option>");
                        select1.append("<option value=\"LPSE Kota Solok\">LPSE Kota Solok</option>");
                        select1.append("<option value=\"LPSE Kota Sorong\">LPSE Kota Sorong</option>");
                        select1.append("<option value=\"LPSE Kota Subulussalam\">LPSE Kota Subulussalam</option>");
                        select1.append("<option value=\"LPSE Kota Sungai Penuh\">LPSE Kota Sungai Penuh</option>");
                        select1.append("<option value=\"LPSE Kota Surabaya\">LPSE Kota Surabaya</option>");
                        select1.append("<option value=\"LPSE Kota Surakarta\">LPSE Kota Surakarta</option>");
                        select1.append("<option value=\"LPSE Kota Tangerang\">LPSE Kota Tangerang</option>");
                        select1.append("<option value=\"LPSE Kota Tangerang Selatan\">LPSE Kota Tangerang Selatan</option>");
                        select1.append("<option value=\"LPSE Kota Tanjung Balai\">LPSE Kota Tanjung Balai</option>");
                        select1.append("<option value=\"LPSE Kota Tanjung Pinang\">LPSE Kota Tanjung Pinang</option>");
                        select1.append("<option value=\"LPSE Kota Tarakan\">LPSE Kota Tarakan</option>");
                        select1.append("<option value=\"LPSE Kota Tasikmalaya\">LPSE Kota Tasikmalaya</option>");
                        select1.append("<option value=\"LPSE Kota Tebing Tinggi\">LPSE Kota Tebing Tinggi</option>");
                        select1.append("<option value=\"LPSE Kota Tegal\">LPSE Kota Tegal</option>");
                        select1.append("<option value=\"LPSE Kota Ternate\">LPSE Kota Ternate</option>");
                        select1.append("<option value=\"LPSE Kota Tidore Kepulauan\">LPSE Kota Tidore Kepulauan</option>");
                        select1.append("<option value=\"LPSE Kota Tomohon\">LPSE Kota Tomohon</option>");
                        select1.append("<option value=\"LPSE Kota Tual\">LPSE Kota Tual</option>");
                        select1.append("<option value=\"LPSE Kota Yogyakarta\">LPSE Kota Yogyakarta</option>");
                        select1.append("<option value=\"LPSE Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah\">LPSE Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah</option>");
                        select1.append("<option value=\"LPSE Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah\">LPSE Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah</option>");
                        select1.append("<option value=\"LPSE Lembaga Ketahanan Nasional\">LPSE Lembaga Ketahanan Nasional</option>");
                        select1.append("<option value=\"LPSE Mahkamah Agung Republik Indonesia\">LPSE Mahkamah Agung Republik Indonesia</option>");
                        select1.append("<option value=\"LPSE Mahkamah Konstitusi\">LPSE Mahkamah Konstitusi</option>");
                        select1.append("<option value=\"LPSE Majelis Permusyawaratan Rakyat Republik Indonesia\">LPSE Majelis Permusyawaratan Rakyat Republik Indonesia</option>");
                        select1.append("<option value=\"LPSE Provinsi Aceh\">LPSE Provinsi Aceh</option>");
                        select1.append("<option value=\"LPSE Provinsi Bali\">LPSE Provinsi Bali</option>");
                        select1.append("<option value=\"LPSE Provinsi Banten\">LPSE Provinsi Banten</option>");
                        select1.append("<option value=\"LPSE Provinsi Bengkulu\">LPSE Provinsi Bengkulu</option>");
                        select1.append("<option value=\"LPSE Provinsi Daerah Istimewa Yogyakarta\">LPSE Provinsi Daerah Istimewa Yogyakarta</option>");
                        select1.append("<option value=\"LPSE Provinsi Daerah Khusus Ibukota Jakarta\">LPSE Provinsi Daerah Khusus Ibukota Jakarta</option>");
                        select1.append("<option value=\"LPSE Provinsi Jambi\">LPSE Provinsi Jambi</option>");
                        select1.append("<option value=\"LPSE Provinsi Jawa Barat\">LPSE Provinsi Jawa Barat</option>");
                        select1.append("<option value=\"LPSE Provinsi Jawa Tengah\">LPSE Provinsi Jawa Tengah</option>");
                        select1.append("<option value=\"LPSE Provinsi Jawa Timur\">LPSE Provinsi Jawa Timur</option>");
                        select1.append("<option value=\"LPSE Provinsi Kalimantan Barat\">LPSE Provinsi Kalimantan Barat</option>");
                        select1.append("<option value=\"LPSE Provinsi Kalimantan Selatan\">LPSE Provinsi Kalimantan Selatan</option>");
                        select1.append("<option value=\"LPSE Provinsi Kalimantan Tengah\">LPSE Provinsi Kalimantan Tengah</option>");
                        select1.append("<option value=\"LPSE Provinsi Kalimantan Timur\">LPSE Provinsi Kalimantan Timur</option>");
                        select1.append("<option value=\"LPSE Provinsi Kalimantan Utara\">LPSE Provinsi Kalimantan Utara</option>");
                        select1.append("<option value=\"LPSE Provinsi Kepulauan Bangka Belitung\">LPSE Provinsi Kepulauan Bangka Belitung</option>");
                        select1.append("<option value=\"LPSE Provinsi Kepulauan Riau\">LPSE Provinsi Kepulauan Riau</option>");
                        select1.append("<option value=\"LPSE Provinsi Lampung\">LPSE Provinsi Lampung</option>");
                        select1.append("<option value=\"LPSE Provinsi Maluku\">LPSE Provinsi Maluku</option>");
                        select1.append("<option value=\"LPSE Provinsi Maluku Utara\">LPSE Provinsi Maluku Utara</option>");
                        select1.append("<option value=\"LPSE Provinsi Nusa Tenggara Barat\">LPSE Provinsi Nusa Tenggara Barat</option>");
                        select1.append("<option value=\"LPSE Provinsi Nusa Tenggara Timur\">LPSE Provinsi Nusa Tenggara Timur</option>");
                        select1.append("<option value=\"LPSE Provinsi Papua\">LPSE Provinsi Papua</option>");
                        select1.append("<option value=\"LPSE Provinsi Papua Barat\">LPSE Provinsi Papua Barat</option>");
                        select1.append("<option value=\"LPSE Provinsi Riau\">LPSE Provinsi Riau</option>");
                        select1.append("<option value=\"LPSE Provinsi Sulawesi Barat\">LPSE Provinsi Sulawesi Barat</option>");
                        select1.append("<option value=\"LPSE Provinsi Sulawesi Selatan\">LPSE Provinsi Sulawesi Selatan</option>");
                        select1.append("<option value=\"LPSE Provinsi Sulawesi Tengah\">LPSE Provinsi Sulawesi Tengah</option>");
                        select1.append("<option value=\"LPSE Provinsi Sulawesi Tenggara\">LPSE Provinsi Sulawesi Tenggara</option>");
                        select1.append("<option value=\"LPSE Provinsi Sulawesi Utara\">LPSE Provinsi Sulawesi Utara</option>");
                        select1.append("<option value=\"LPSE Provinsi Sumatera Barat\">LPSE Provinsi Sumatera Barat</option>");
                        select1.append("<option value=\"LPSE Provinsi Sumatera Selatan\">LPSE Provinsi Sumatera Selatan</option>");
                        select1.append("<option value=\"LPSE Provinsi Sumatera Utara\">LPSE Provinsi Sumatera Utara</option>");
                        select1.append("<option value=\"LPSE Sekretariat Jenderal Dewan Ketahanan Nasional\">LPSE Sekretariat Jenderal Dewan Ketahanan Nasional</option>");
                        select1.append("<option value=\"LPSE Sekretariat Jenderal Dewan Perwakilan Daerah Republik Indonesia\">LPSE Sekretariat Jenderal Dewan Perwakilan Daerah Republik Indonesia</option>");
                        select1.append("<option value=\"LPSE Tentara Nasional Indonesia\">LPSE Tentara Nasional Indonesia</option>");
                        select1.append("<option value=\"LPSE TNI Angkatan Laut\">LPSE TNI Angkatan Laut</option>");
                        select1.append("<option value=\"LPSE TNI Angkatan Udara\">LPSE TNI Angkatan Udara</option>");
                        select1.append("<option value=\"LPSE Universitas Diponegoro\">LPSE Universitas Diponegoro</option>");
                        select1.append("<option value=\"LPSE Universitas Indonesia\">LPSE Universitas Indonesia</option>");
                        select1.append("<option value=\"SPSE Nasional\">SPSE Nasional</option>");

                        $("#select-all").on("click", function() {
                            $(".row-checkbox").prop("checked", this.checked);
                        });
                    }');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->hidden(),
            Column::computed('checkbox')
                ->title('<div class="form-check"><input class="form-check-input checkbox-primary" id="select-all" type="checkbox"></div>')
                ->exportable(false)
                ->printable(false)
                ->width(10)
                ->addClass('text-center'),
            Column::make('updated_at')
                  ->title('Tanggal Diupdate')
                  ->orderable(true),
            Column::make('tender_id')
                  ->title('Kode')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('nama_paket')
                  ->title('Nama Paket')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('lpse.nama_lpse')
                  ->title('Nama KLPDI')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('tahap_tender')
                  ->title('Tahapan')
                  ->name('tahap_tender')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('hps')
                  ->title('HPS')
                  ->searchable(true)
                  ->orderable(true),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Tender_' . date('YmdHis');
    }
}
