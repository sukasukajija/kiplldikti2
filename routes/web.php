<?php

use App\Http\Controllers\PengajuanAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluasiOperatorController;
use App\Http\Controllers\MahasiswaBankController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaDitetapkanController;
use App\Http\Controllers\MahasiswaHistoryController;
use App\Http\Controllers\MahasiswaPddiktiController;
use App\Http\Controllers\PencairanAdminController;
use App\Http\Controllers\PencairanController;
use App\Http\Controllers\PencairanOngoingKelulusanController;
use App\Http\Controllers\PencairanOngoingOperatorController;
use App\Http\Controllers\PencairanOngoingPembatalanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PencairanOperatorController;
use App\Http\Controllers\PencairanPembatalanController;
use App\Http\Controllers\PerguruanTinggiController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Auth::routes(['verify' => true]);

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::get('/pengajuan/tipe', function (Request $request) {
    return view('layouts.digitalisasi.pengajuan_operator.pilih_tipe', ['periode_id' => $request->query('periode_id')]);
})->name('pengajuan.pilih_tipe');


Route::get('/export-mahasiswas', [MahasiswaController::class, 'export'])->name('mahasiswa.export');

Route::get('/test-email', function () {
    Mail::raw('Ini email test SMTP Laravel', function ($message) {
        $message->to('kimazizah00@gmail.com')
                ->subject('Test Email Laravel SMTP');
    });
    return 'Email sudah dikirim!';
});

Route::middleware(['auth'])->group(function () {
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/blank-page', [App\Http\Controllers\HomeController::class, 'blank'])->name('blank');

    Route::get('/notifications/mark-all-read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('notifications.markAllAsRead');

    Route::post('/mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');
    Route::post('/mahasiswa/import-finalisasi', [MahasiswaController::class, 'importFinalisasi'])->name('mahasiswa.import-finalisasi');
    Route::get('/mahasiswa/download-template', [MahasiswaController::class, 'downloadTemplate'])->name('mahasiswa.download-template');
    Route::get('/mahasiswa/download-template-finalisasi', [MahasiswaController::class, 'downloadFinalisasiTemplate'])->name('mahasiswa.download-template-finalisasi');


    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/ganti-password', [ProfileController::class, 'gantipassword'])->name('profile.gantipassword');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    Route::middleware(['superadmin'])->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
        Route::get('/admin/dashboard/filter', [DashboardController::class, 'filter'])->name('admin_dashboard.filter');

        Route::get('/hakakses', [App\Http\Controllers\HakaksesController::class, 'index'])->name('hakakses.index');
        Route::get('/hakakses/create', [App\Http\Controllers\HakaksesController::class, 'create'])->name('hakakses.create');
        Route::post('/hakakses/store', [App\Http\Controllers\HakaksesController::class, 'store'])->name('hakakses.store');
        Route::get('/hakakses/edit/{id}', [App\Http\Controllers\HakaksesController::class, 'edit'])->name('hakakses.edit');
        Route::put('/hakakses/update/{id}', [App\Http\Controllers\HakaksesController::class, 'update'])->name('hakakses.update');
        Route::delete('/hakakses/delete/{id}', [App\Http\Controllers\HakaksesController::class, 'destroy'])->name('hakakses.delete');

        Route::get('/klaster_wilayah', [App\Http\Controllers\KlasterWilayahController::class, 'index'])->name('klaster_wilayah.index');
        Route::post('/klaster_wilayah/store', [App\Http\Controllers\KlasterWilayahController::class, 'store'])->name('klaster_wilayah.store');
        Route::get('/klaster_wilayah/create', [App\Http\Controllers\KlasterWilayahController::class, 'create'])->name('klaster_wilayah.create');
        Route::get('/klaster_wilayah/edit/{id}', [App\Http\Controllers\KlasterWilayahController::class, 'edit'])->name('klaster_wilayah.edit');
        Route::put('/klaster_wilayah/update/{id}', [App\Http\Controllers\KlasterWilayahController::class, 'update'])->name('klaster_wilayah.update');
        Route::delete('/klaster_wilayah/delete/{id}', [App\Http\Controllers\KlasterWilayahController::class, 'destroy'])->name('klaster_wilayah.delete');

        Route::get('/periode_penetapan', [App\Http\Controllers\PeriodePenetapanController::class, 'index'])->name('periode_penetapan.index');
        Route::post('/periode_penetapan/store', [App\Http\Controllers\PeriodePenetapanController::class, 'store'])->name('periode_penetapan.store');
        Route::get('/periode_penetapan/create', [App\Http\Controllers\PeriodePenetapanController::class, 'create'])->name('periode_penetapan.create');
        Route::get('/periode_penetapan/edit/{id}', [App\Http\Controllers\PeriodePenetapanController::class, 'edit'])->name('periode_penetapan.edit');
        Route::put('/periode_penetapan/update/{id}', [App\Http\Controllers\PeriodePenetapanController::class, 'update'])->name('periode_penetapan.update');
        Route::delete('/periode_penetapan/delete/{id}', [App\Http\Controllers\PeriodePenetapanController::class, 'destroy'])->name('periode_penetapan.delete');
        Route::get('/periode_penetapan/set_active/{id}', [App\Http\Controllers\PeriodePenetapanController::class, 'setActive'])->name('periode_penetapan.set_active');

        Route::get('/perguruan_tinggi', [App\Http\Controllers\PerguruanTinggiController::class, 'index'])->name('perguruan_tinggi.index');
        Route::get('/perguruan_tinggi/create', [App\Http\Controllers\PerguruanTinggiController::class, 'create'])->name('perguruan_tinggi.create');
        Route::post('/perguruan_tinggi/store', [App\Http\Controllers\PerguruanTinggiController::class, 'store'])->name('perguruan_tinggi.store');
        Route::get('/perguruan_tinggi/edit/{id}', [App\Http\Controllers\PerguruanTinggiController::class, 'edit'])->name('perguruan_tinggi.edit');
        Route::put('/perguruan_tinggi/update/{id}', [App\Http\Controllers\PerguruanTinggiController::class, 'update'])->name('perguruan_tinggi.update');
        Route::delete('/perguruan_tinggi/delete/{id}', [App\Http\Controllers\PerguruanTinggiController::class, 'destroy'])->name('perguruan_tinggi.delete');

        Route::resource('/admin/mahasiswa-pddikti', MahasiswaPddiktiController::class);
        Route::post('/mahasiswa-pddikti/update-status/{id}', [MahasiswaPddiktiController::class, 'updateStatus'])->name('mahasiswa_pddikti.updateStatus');
        Route::get('/admin/laporan', [MahasiswaHistoryController::class, 'historyAdmin'])->name('admin.laporan');

        Route::get('/admin/chart-data', [DashboardController::class, 'getChartData']);

        Route::get('/admin/pencairan', [PencairanAdminController::class, 'index'])->name('pencairan_admin.index');
        Route::get('/admin/pencairan/{pencairan_id}', [PencairanAdminController::class, 'show'])->name('pencairan_admin.detail');
        Route::get('/admin/pencairan/approve/{pencairan_id}', [PencairanAdminController::class, 'approve'])->name('pencairan_admin.approve');
        Route::get('/admin/pencairan/reject/{pencairan_id}', [PencairanAdminController::class, 'reject'])->name('pencairan_admin.reject');
        Route::post('/admin/pencairan/reject/{pencairan_id}', [PencairanAdminController::class, 'rejectPost'])->name('pencairan_admin.reject.post');

        Route::get('/admin/pencairan/export-excel/pengajuans[]', [PencairanAdminController::class, 'export'])->name('pencairan_admin.export-finalisasi');

        // pengajuan penetapan awal
        Route::prefix('pengajuan')->middleware('auth')->group(function () {
            Route::get('/', [PengajuanAdminController::class, 'index'])->name('pengajuan_admin.index');
            Route::get('/{id}', [PengajuanAdminController::class, 'show'])->name('pengajuan_admin.show');
            Route::get('/approve/{id}', [PengajuanAdminController::class, 'approve'])->name('pengajuan_admin.approve');
            Route::get('/reject/{id}', [PengajuanAdminController::class, 'reject'])->name('pengajuan_admin.reject');
            Route::post('/reject/{id}', [PengajuanAdminController::class, 'rejectPost'])->name('pengajuan_admin.rejectPost');
            Route::get('/export/pengajuans[]', [PengajuanController::class, 'exportPengajuanAwal'])->name('pengajuan_admin.export');

         });


         Route::prefix('/admin/mahasiswa-finalisasi')->group(function () {
            Route::get('/', [PencairanController::class, 'index'])->name('mahasiswa_finalisasi_admin');
         });
    });

    Route::get('/buat-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link berhasil dibuat.';
    });

    Route::get('/program_studi', [App\Http\Controllers\ProgramStudiController::class, 'index'])->name('program_studi.index');
    Route::get('/program_studi/create', [App\Http\Controllers\ProgramStudiController::class, 'create'])->name('program_studi.create');
    Route::post('/program_studi/store', [App\Http\Controllers\ProgramStudiController::class, 'store'])->name('program_studi.store');
    Route::get('/program_studi/edit/{id}', [App\Http\Controllers\ProgramStudiController::class, 'edit'])->name('program_studi.edit');
    Route::put('/program_studi/update/{id}', [App\Http\Controllers\ProgramStudiController::class, 'update'])->name('program_studi.update');
    Route::delete('/program_studi/delete/{id}', [App\Http\Controllers\ProgramStudiController::class, 'destroy'])->name('program_studi.delete');


    Route::middleware(['operatorpt'])->group(function () {

       Route::get('/dashboard/operator', [DashboardController::class, 'opt'])->name('dashboard.operator');
       // pengajuan penetapan awal ditolak
       Route::prefix('pengajuan-ditolak')->group(function () {
           Route::get('/', [PengajuanController::class, 'getRejectedPengajuans'])->name('pengajuan_ditolak');
           Route::get('/{id}', [PengajuanController::class, 'getDetailRejectedPengajuan'])->name('pengajuan_ditolak.detail');
           Route::post('/{id}', [PengajuanController::class, 'pengajuanUlang'])->name('pengajuan_ditolak.pengajuanUlang');
       });

       Route::get('/detail-penolakan/{id}', [PencairanController::class, 'detailPenolakan'])->name('operator.detail_penolakan');
       Route::post('/ajukan-ulang/{id}', [PencairanController::class, 'ajukanUlang'])->name('operator.ajukan_ulang');
    // pengajuan pencairan
        Route::prefix('pencairan')->group(function () {
            Route::get('/', [PencairanOperatorController::class, 'index'])->name('pencairan.index');
            Route::prefix('/{periode_id}')->group(function () {
               Route::get('/pilih-pengajuan', [PencairanOperatorController::class, 'selectTipePengajuan'])->name('pencairan.selectTipePengajuan');
               Route::prefix('/baru')->group(function () {
                     Route::get('/', [PencairanOperatorController::class, 'selectTipe'])->name('pencairan.selectTipePencairan');
                     Route::get('/select-tipe', [PencairanOperatorController::class, 'selectTipe'])->name('pencairan.baru.select_tipe');
                     Route::get('/ajukan', [PencairanOperatorController::class, 'ajukan'])->name('pencairan.baru.ajukan');
                     Route::post('/ajukan', [PencairanOperatorController::class, 'ajukanStore'])->name('pencairan.baru.ajukan.store');
                     Route::get('/edit-bank/{mahasiswa_id}', [MahasiswaBankController::class, 'create'])->name('pencairan.baru.edit_bank');
                     Route::post('/edit-bank/{mahasiswa_id}', [MahasiswaBankController::class, 'store'])->name('pencairan.baru.edit_bank.store');
                     Route::prefix('pembatalan')->group(function () {
                        Route::get('/', [PencairanPembatalanController::class, 'index'])->name('pencairan.baru.pembatalan');
                        Route::post('/', [PencairanPembatalanController::class, 'store'])->name('pencairan.baru.pembatalan.store');
                        Route::get('/upload-sk', [PencairanPembatalanController::class, 'uploadSk'])->name('pencairan.baru.pembatalan.upload.sk');
                        Route::post('/upload-sk', [PencairanPembatalanController::class, 'uploadSkStore'])->name('pencairan.baru.pembatalan.upload.sk.store');
                     });
               });
               Route::prefix('/ongoing')->group(function () {

                  Route::get('/', [PencairanOngoingOperatorController::class, 'selectTipe'])->name('select_tipe_pencairan.ongoing');


                  Route::prefix('evaluasi')->group(function () {
                      Route::get('/', [EvaluasiOperatorController::class, 'index'])->name('evaluasi.index');
                      Route::get('/upload-ba', [EvaluasiOperatorController::class, 'uploadBa'])->name('evaluasi.upload-ba');
                      Route::post('/upload-ba', [EvaluasiOperatorController::class, 'uploadBaPost'])->name('evaluasi.upload-ba.post');
                      Route::get('/create/{mahasiswa_id}', [EvaluasiOperatorController::class, 'create'])->name('evaluasi.create');
                      Route::post('/{mahasiswa_id}', [EvaluasiOperatorController::class, 'store'])->name('evaluasi.store');
                  });

                  Route::prefix('penetapan-kembali')->group(function () {
                      Route::get('/', [PencairanOngoingOperatorController::class, 'selectBank'])
                          ->name('pencairan.ongoing.penetapan-kembali');

                          Route::prefix('{bank_id}')->group(function () {
                              Route::get('/', [PencairanOngoingOperatorController::class, 'uploadDokumen'])
                                  ->name('pencairan.ongoing.penetapan-kembali.upload-dokumen');
                              Route::post('/', [PencairanOngoingOperatorController::class, 'uploadDokumenPost'])
                                  ->name('pencairan.ongoing.penetapan-kembali.upload-dokumen.post');

                              Route::prefix('{jenis_bantuan_id}')->group(function () {
                                  Route::get('/', [PencairanOngoingOperatorController::class, 'selectMahasiswa'])
                                      ->name('pencairan.ongoing.penetapan-kembali.select-mahasiswa');

                                  Route::post('/', [PencairanOngoingOperatorController::class, 'selectMahasiswaPost'])
                                      ->name('pencairan.ongoing.penetapan-kembali.select-mahasiswa.post');
                                  Route::get('/upload-sk', [PencairanOngoingOperatorController::class, 'uploadSk'])
                                      ->name('pencairan.ongoing.penetapan-kembali.upload-sk');
                                  Route::post('/upload-sk', [PencairanOngoingOperatorController::class, 'uploadSkPost'])
                                      ->name('pencairan.ongoing.penetapan-kembali.upload-sk.post');


                              });
                          });
                  });


                  Route::prefix('pembatalan')->group(function () {

                     Route::get('/', [PencairanOngoingPembatalanController::class, 'selectJenisBantuan'])->name('pencairan.ongoing.pembatalan');
                     Route::post('/', [PencairanOngoingPembatalanController::class, 'selectJenisBantuanPost'])->name('pencairan.ongoing.pembatalan.post');
                     Route::prefix('{jenis_bantuan_id}')->group(function () {
                        Route::get('/', [PencairanOngoingPembatalanController::class, 'selectMahasiswa'])->name('pencairan.ongoing.pembatalan.select-mahasiswa');
                        Route::post('/', [PencairanOngoingPembatalanController::class, 'selectMahasiswaPost'])->name('pencairan.ongoing.pembatalan.select-mahasiswa.post');
                        Route::get('/upload-sk', [PencairanOngoingPembatalanController::class, 'uploadSk'])->name('pencairan.ongoing.pembatalan.upload-sk');
                        Route::post('/upload-sk', [PencairanOngoingPembatalanController::class, 'uploadSkPost'])->name('pencairan.ongoing.pembatalan.upload-sk.post');
                     });

                  });


                  Route::prefix('kelulusan')->group(function () {
                     Route::get('/', [PencairanOngoingKelulusanController::class, 'selectJenisBantuan'])->name('pencairan.ongoing.kelulusan');
                     Route::post('/', [PencairanOngoingKelulusanController::class, 'selectJenisBantuanPost'])->name('pencairan.ongoing.kelulusan.post');
                     Route::prefix('{jenis_bantuan_id}')->group(function () {
                        Route::get('/', [PencairanOngoingKelulusanController::class, 'selectMahasiswa'])->name('pencairan.ongoing.kelulusan.select-mahasiswa');
                        Route::post('/', [PencairanOngoingKelulusanController::class, 'selectMahasiswaPost'])->name('pencairan.ongoing.kelulusan.select-mahasiswa.post');
                        Route::get('/upload-sk', [PencairanOngoingKelulusanController::class, 'uploadSk'])->name('pencairan.ongoing.kelulusan.upload-sk');
                        Route::post('/upload-sk', [PencairanOngoingKelulusanController::class, 'uploadSkPost'])->name('pencairan.ongoing.kelulusan.upload-sk.post');
                        Route::get('/edit-tanggal-yudisium/{mahasiswa_id}', [PencairanOngoingKelulusanController::class, 'editTanggalYudisium'])->name('pencairan.ongoing.kelulusan.edit-tanggal-yudisium');
                        Route::post('/edit-tanggal-yudisium/{mahasiswa_id}', [PencairanOngoingKelulusanController::class, 'editTanggalYudisiumPost'])->name('pencairan.ongoing.kelulusan.edit-tanggal-yudisium.post');
                     });
                  });
               });
            });
        });


        Route::get('/pengajuan_penetapan', [App\Http\Controllers\PengajuanController::class, 'index'])->name('pengajuan_penetapan.index');
        Route::get('pengajuan_penetapan/upload_dokumen/{periode_penetapan_id}', [App\Http\Controllers\PengajuanController::class, 'uploadDokumen'])->name('pengajuan_penetapan.upload_dokumen');
        Route::post('pengajuan_penetapan/upload_dokumen/{periode_penetapan_id}', [App\Http\Controllers\PengajuanController::class, 'uploadDokumenPost'])->name('pengajuan_penetapan.upload_dokumen_post');
        Route::get('/pengajuan_penetapan/{periode_penetapan_id}/create', [App\Http\Controllers\PengajuanController::class, 'create'])->name('pengajuan_penetapan.create');
        Route::post('/pengajuan_penetapan/store', [App\Http\Controllers\PengajuanController::class, 'store'])->name('pengajuan_penetapan.store');

        Route::get('/laporan/history', [PengajuanController::class, 'history'])->name('pengajuan.history');

        Route::post('/perguruan_tinggi/dokumen/{id}', [PerguruanTinggiController::class, 'storeDokumen'])->name('perguruan_tinggi.store_dokumen');
        Route::get('/perguruan_tinggi/dokumen/{id}', [PerguruanTinggiController::class, 'showDokumen'])->name('perguruan_tinggi.upload_dokumen');

        Route::get('/mahasiswa', [App\Http\Controllers\MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa/create', [App\Http\Controllers\MahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/mahasiswa/store', [App\Http\Controllers\MahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('/mahasiswa/edit/{id}', [App\Http\Controllers\MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/update/{id}', [App\Http\Controllers\MahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::delete('/mahasiswa/delete/{id}', [App\Http\Controllers\MahasiswaController::class, 'destroy'])->name('mahasiswa.delete');


        Route::get('/operator/mahasiswa-ditetapkan', [MahasiswaDitetapkanController::class, 'operatorDitetapkan'])->name('mahasiswa_ditetapkan.operatorDitetapkan');
        Route::get('/operator/chart-data', [DashboardController::class, 'getChartDataOpt']);

    });
});
