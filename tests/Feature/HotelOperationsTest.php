<?php

namespace Tests\Feature;

use App\Models\Kamar;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelOperationsTest extends TestCase
{
    use RefreshDatabase;

    protected User $manajer;
    protected User $resepsionis;
    protected User $kebersihan;
    protected User $tamu;
    protected Kamar $kamar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manajer = User::create([
            'nama' => 'Pak Manajer',
            'email' => 'manajer@test.com',
            'password' => bcrypt('password123'),
            'peran' => 'Manajer',
            'aktif' => true,
            'no_identitas' => 'NIK-MGR-001',
        ]);

        $this->resepsionis = User::create([
            'nama' => 'Mbak Resepsionis',
            'email' => 'resepsionis@test.com',
            'password' => bcrypt('password123'),
            'peran' => 'Resepsionis',
            'aktif' => true,
            'no_identitas' => 'NIK-RCP-001',
        ]);

        $this->kebersihan = User::create([
            'nama' => 'Mas Kebersihan',
            'email' => 'kebersihan@test.com',
            'password' => bcrypt('password123'),
            'peran' => 'Petugas Kebersihan',
            'aktif' => true,
            'no_identitas' => 'NIK-CLN-001',
        ]);

        $this->tamu = User::create([
            'nama' => 'Tamu Contoh',
            'email' => 'tamu@test.com',
            'password' => bcrypt('password123'),
            'peran' => 'Tamu',
            'aktif' => true,
            'no_identitas' => 'NIK-TMU-001',
        ]);

        $this->kamar = Kamar::create([
            'nomor_kamar' => '101',
            'tipe' => 'Standar',
            'harga_per_malam' => 300000,
            'status' => 'Tersedia',
            'status_kebersihan' => 'Bersih',
        ]);
    }

    /** Test 1: Nomor kamar tidak boleh ganda */
    public function test_nomor_kamar_tidak_boleh_ganda(): void
    {
        $response = $this->actingAs($this->manajer)->post(route('manajer.kamar.store'), [
            'nomor_kamar' => '101', // Sudah ada di database
            'tipe' => 'Deluxe',
            'harga_per_malam' => 500000,
            'status' => 'Tersedia',
            'status_kebersihan' => 'Bersih',
        ]);

        $response->assertSessionHasErrors('nomor_kamar');
    }

    /** Test 2: Harga per malam harus lebih dari 0 */
    public function test_harga_per_malam_harus_lebih_dari_nol(): void
    {
        $response = $this->actingAs($this->manajer)->post(route('manajer.kamar.store'), [
            'nomor_kamar' => '102',
            'tipe' => 'Deluxe',
            'harga_per_malam' => 0, // Tidak boleh <= 0
            'status' => 'Tersedia',
            'status_kebersihan' => 'Bersih',
        ]);

        $response->assertSessionHasErrors('harga_per_malam');
    }

    /** Test 3: Nomor identitas pengguna tidak boleh ganda */
    public function test_no_identitas_pengguna_tidak_boleh_ganda(): void
    {
        $response = $this->actingAs($this->resepsionis)->post(route('resepsionis.tamu.store'), [
            'nama' => 'Tamu Baru',
            'no_identitas' => 'NIK-TMU-001', // Duplikat dengan tamu yang sudah ada
            'email' => 'tamu.baru@test.com',
        ]);

        $response->assertSessionHasErrors('no_identitas');
    }

    /** Test 4: Resepsionis dilarang menghapus data kamar (RBAC Check) */
    public function test_resepsionis_dilarang_menghapus_kamar(): void
    {
        $response = $this->actingAs($this->resepsionis)->delete(route('manajer.kamar.destroy', $this->kamar->id));

        $response->assertStatus(403);
    }

    /** Test 5: Resepsionis dilarang mengakses laporan manajerial (RBAC Check) */
    public function test_resepsionis_dilarang_mengakses_laporan_pendapatan(): void
    {
        $response = $this->actingAs($this->resepsionis)->get(route('laporan.pendapatan'));

        $response->assertStatus(403);
    }

    /** Test 6: Check-in otomatis mengubah status kamar menjadi Terisi */
    public function test_proses_check_in_mengubah_status_kamar_menjadi_terisi(): void
    {
        $pemesanan = Pemesanan::create([
            'kode_booking' => 'BKG-TEST-001',
            'tamu_id' => $this->tamu->id,
            'kamar_id' => $this->kamar->id,
            'tanggal_check_in' => today(),
            'tanggal_check_out' => today()->addDays(2),
            'total_harga' => 600000,
            'status' => 'Dipesan',
            'pembuat_id' => $this->resepsionis->id,
        ]);

        $response = $this->actingAs($this->resepsionis)->post(route('resepsionis.pemesanan.checkin', $pemesanan->id));
        $response->assertRedirect();

        $this->assertEquals('Check-in', $pemesanan->fresh()->status);
        $this->assertEquals('Terisi', $this->kamar->fresh()->status);
    }

    /** Test 7: Check-out otomatis mencatat pembayaran dan mengubah kamar menjadi Kotor */
    public function test_proses_check_out_mencatat_pembayaran_dan_ubah_kebersihan_menjadi_kotor(): void
    {
        $pemesanan = Pemesanan::create([
            'kode_booking' => 'BKG-TEST-002',
            'tamu_id' => $this->tamu->id,
            'kamar_id' => $this->kamar->id,
            'tanggal_check_in' => today()->subDays(2),
            'tanggal_check_out' => today(),
            'total_harga' => 600000,
            'status' => 'Check-in',
            'pembuat_id' => $this->resepsionis->id,
        ]);
        $this->kamar->update(['status' => 'Terisi', 'status_kebersihan' => 'Bersih']);

        $response = $this->actingAs($this->resepsionis)->post(route('resepsionis.pemesanan.checkout', $pemesanan->id), [
            'metode_pembayaran' => 'Tunai',
            'jumlah_bayar' => 700000, // Bayar 700rb, kembalian 100rb
        ]);

        $response->assertRedirect(route('resepsionis.invoice', $pemesanan->id));

        $this->assertEquals('Check-out', $pemesanan->fresh()->status);
        $this->assertEquals('Kotor', $this->kamar->fresh()->status_kebersihan);
        $this->assertDatabaseHas('pembayarans', [
            'pemesanan_id' => $pemesanan->id,
            'metode_pembayaran' => 'Tunai',
            'jumlah_bayar' => 700000,
            'kembalian' => 100000,
        ]);
    }

    /** Test 8: Petugas kebersihan menandai bersih otomatis mengubah kamar menjadi Tersedia */
    public function test_petugas_kebersihan_menandai_bersih_mengubah_kamar_menjadi_tersedia(): void
    {
        $this->kamar->update([
            'status' => 'Tersedia',
            'status_kebersihan' => 'Kotor',
        ]);

        $response = $this->actingAs($this->kebersihan)->post(route('kebersihan.kamar.bersih', $this->kamar->id));
        $response->assertRedirect();

        $freshKamar = $this->kamar->fresh();
        $this->assertEquals('Bersih', $freshKamar->status_kebersihan);
        $this->assertEquals('Tersedia', $freshKamar->status);
    }

    /** Test 9: Manajer dapat mengakses ketiga laporan */
    public function test_manajer_dapat_mengakses_semua_laporan(): void
    {
        $this->actingAs($this->manajer)->get(route('laporan.okupansi'))->assertOk();
        $this->actingAs($this->manajer)->get(route('laporan.pendapatan'))->assertOk();
        $this->actingAs($this->manajer)->get(route('laporan.riwayat_tamu'))->assertOk();
    }
}
