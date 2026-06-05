<?php

namespace Tests\Unit\Models;

use App\Models\PresensimemberModel;
use App\Models\memberModel;
use App\Libraries\enums\Kehadiran;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\I18n\Time;

/**
 * @internal
 */
final class PresensimemberModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = true;
    protected $namespace   = null;
    protected $seed        = ['\App\Database\Seeds\KehadiranSeeder'];
    protected $seedOnce    = true;

    protected PresensimemberModel $model;
    protected $testmemberId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new PresensimemberModel();
        
        // Setup test data
        $this->db->table('tb_member')->insert([
            '' => '1234567890123456',
            'nama_member' => 'Test member',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Test',
            'no_hp' => '08123456789',
            'unique_code' => 'test-member-code-123',
        ]);
        
        $this->testmemberId = $this->db->insertID();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->table('tb_member')->delete(['id_member' => $this->testmemberId]);        
    }

    // =====================================================
    // HAPPY PATH TESTS
    // =====================================================

    public function testCekAbsenReturnsFalseWhenNoAttendance(): void
    {
        $date = Time::today()->toDateString();
        $result = $this->model->cekAbsen($this->testmemberId, $date);
        
        $this->assertFalse($result);
    }

    public function testCekAbsenReturnsIdPresensiWhenAttendanceExists(): void
    {
        $date = Time::today()->toDateString();
        $time = Time::now()->toTimeString();
        
        // Create attendance
        $this->model->absenMasuk($this->testmemberId, $date, $time);
        
        $result = $this->model->cekAbsen($this->testmemberId, $date);
        
        $this->assertNotFalse($result);
        $this->assertIsInt(intval($result));
        $this->assertGreaterThan(0, intval($result));
    }

    public function testAbsenMasukCreatesNewAttendanceRecord(): void
    {
        $date = Time::today()->toDateString();
        $time = Time::now()->toTimeString();
        
        $this->model->absenMasuk($this->testmemberId, $date, $time);
        
        $presensi = $this->model->getPresensiByIdmemberTanggal($this->testmemberId, $date);
        
        $this->assertNotNull($presensi);
        $this->assertEquals($this->testmemberId, $presensi['id_member']);
        $this->assertEquals($date, $presensi['tanggal']);
        $this->assertEquals($time, $presensi['jam_masuk']);
        $this->assertNull($presensi['jam_keluar']);
        $this->assertEquals(Kehadiran::Hadir->value, $presensi['id_kehadiran']);
        $this->assertEquals('', $presensi['keterangan']);
    }

    public function testAbsenKeluarUpdatesExistingAttendance(): void
    {
        $date = Time::today()->toDateString();
        $timeMasuk = '07:00:00';
        $timeKeluar = '15:00:00';
        
        // Create entry attendance
        $this->model->absenMasuk($this->testmemberId, $date, $timeMasuk);
        $idPresensi = $this->model->cekAbsen($this->testmemberId, $date);
        
        // Update exit attendance
        $this->model->absenKeluar($idPresensi, $timeKeluar);
        
        $presensi = $this->model->getPresensiById($idPresensi);
        
        $this->assertNotNull($presensi);
        $this->assertEquals($timeMasuk, $presensi['jam_masuk']);
        $this->assertEquals($timeKeluar, $presensi['jam_keluar']);
    }

    public function testGetPresensiByIdmemberTanggalReturnsCorrectRecord(): void
    {
        $date = Time::today()->toDateString();
        $time = Time::now()->toTimeString();
        
        $this->model->absenMasuk($this->testmemberId, $date, $time);
        
        $result = $this->model->getPresensiByIdmemberTanggal($this->testmemberId, $date);
        
        $this->assertNotNull($result);
        $this->assertIsArray($result);
        $this->assertEquals($this->testmemberId, $result['id_member']);
        $this->assertEquals($date, $result['tanggal']);
    }

    public function testGetPresensiByIdReturnsCorrectRecord(): void
    {
        $date = Time::today()->toDateString();
        $time = Time::now()->toTimeString();
        
        $this->model->absenMasuk($this->testmemberId, $date, $time);
        $idPresensi = $this->model->cekAbsen($this->testmemberId, $date);
        
        $result = $this->model->getPresensiById($idPresensi);
        
        $this->assertNotNull($result);
        $this->assertEquals($idPresensi, $result['id_presensi']);
    }

    public function testUpdatePresensiWithNewRecord(): void
    {
        $date = Time::today()->toDateString();
        $jamMasuk = '07:00:00';
        $jamKeluar = '15:00:00';
        
        $result = $this->model->updatePresensi(
            null,
            $this->testmemberId,
            $date,
            Kehadiran::Sakit->value,
            $jamMasuk,
            $jamKeluar,
            'Sakit demam'
        );
        
        $this->assertTrue($result);
        
        $presensi = $this->model->getPresensiByIdmemberTanggal($this->testmemberId, $date);
        $this->assertNotNull($presensi);
        $this->assertEquals(Kehadiran::Sakit->value, $presensi['id_kehadiran']);
        $this->assertEquals('Sakit demam', $presensi['keterangan']);
    }

    public function testUpdatePresensiWithExistingRecord(): void
    {
        $date = Time::today()->toDateString();
        $time = Time::now()->toTimeString();
        
        // Create initial attendance
        $this->model->absenMasuk($this->testmemberId, $date, $time);
        $idPresensi = $this->model->cekAbsen($this->testmemberId, $date);
        
        // Update attendance
        $result = $this->model->updatePresensi(
            $idPresensi,
            $this->testmemberId,
            $date,
            Kehadiran::Izin->value,
            null,
            null,
            'Izin keperluan keluarga'
        );
        
        $this->assertTrue($result);
        
        $presensi = $this->model->getPresensiById($idPresensi);
        $this->assertEquals(Kehadiran::Izin->value, $presensi['id_kehadiran']);
        $this->assertEquals('Izin keperluan keluarga', $presensi['keterangan']);
    }

    public function testGetPresensiByTanggalReturnsAllTeachers(): void
    {
        $date = Time::today()->toDateString();
        
        // Add another teacher
        $this->db->table('tb_member')->insert([
            '' => '1234567890123457',
            'nama_member' => 'Test member 2',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Test 2',
            'no_hp' => '08123456788',
            'unique_code' => 'test-member-code-124',
        ]);
        
        $memberId2 = $this->db->insertID();
        
        // First teacher has attendance
        $this->model->absenMasuk($this->testmemberId, $date, '07:00:00');
        
        // Second teacher has no attendance
        
        $result = $this->model->getPresensiByTanggal($date);
        
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    // =====================================================
    // UNHAPPY PATH TESTS
    // =====================================================

    public function testCekAbsenWithNonExistentTeacher(): void
    {
        $date = Time::today()->toDateString();
        $result = $this->model->cekAbsen(99999, $date);
        
        $this->assertFalse($result);
    }

    public function testCekAbsenWithDifferentDate(): void
    {
        $date = Time::today()->toDateString();
        $time = Time::now()->toTimeString();
        
        $this->model->absenMasuk($this->testmemberId, $date, $time);
        
        // Check with different date
        $differentDate = Time::tomorrow()->toDateString();
        $result = $this->model->cekAbsen($this->testmemberId, $differentDate);
        
        $this->assertFalse($result);
    }

    public function testGetPresensiByIdmemberTanggalReturnsNullWhenNoRecord(): void
    {
        $date = Time::today()->toDateString();
        $result = $this->model->getPresensiByIdmemberTanggal($this->testmemberId, $date);
        
        $this->assertNull($result);
    }

    public function testGetPresensiByIdReturnsNullForInvalidId(): void
    {
        $result = $this->model->getPresensiById('99999');
        
        $this->assertNull($result);
    }

    public function testAbsenKeluarWithInvalidId(): void
    {
        $time = Time::now()->toTimeString();
        
        // Should not throw error but won't update anything
        $result = $this->model->absenKeluar('99999', $time);
        
        // Model returns false when no rows affected
        $this->assertNull($result);
    }

    public function testUpdatePresensiKeepsExistingKeteranganWhenNull(): void
    {
        $date = Time::today()->toDateString();
        
        // Create initial attendance with keterangan
        $this->model->updatePresensi(
            null,
            $this->testmemberId,
            $date,
            Kehadiran::Sakit->value,
            '07:00:00',
            null,
            'Sakit awal'
        );
        
        $idPresensi = $this->model->cekAbsen($this->testmemberId, $date);
        
        // Update without providing keterangan (null)
        $this->model->updatePresensi(
            $idPresensi,
            $this->testmemberId,
            $date,
            Kehadiran::Hadir->value,
            null,
            '15:00:00',
            null
        );
        
        $presensi = $this->model->getPresensiById($idPresensi);
        
        // Should keep previous keterangan
        $this->assertEquals('Sakit awal', $presensi['keterangan']);
    }

    // =====================================================
    // EDGE CASES
    // =====================================================

    public function testMultipleAbsenMasukOnSameDay(): void
    {
        $date = Time::today()->toDateString();
        
        $this->model->absenMasuk($this->testmemberId, $date, '07:00:00');
        $this->model->absenMasuk($this->testmemberId, $date, '08:00:00');
        
        // Should create 2 records (duplicate entries)
        $records = $this->db->table('tb_presensi_member')
            ->where('id_member', $this->testmemberId)
            ->where('tanggal', $date)
            ->get()
            ->getResultArray();
        
        // Note: Current implementation allows duplicates
        $this->assertGreaterThanOrEqual(2, count($records));
    }

    public function testCekAbsenWithTimeObject(): void
    {
        $date = Time::today();
        $result = $this->model->cekAbsen($this->testmemberId, $date);
        
        $this->assertFalse($result);
    }

    public function testUpdatePresensiOnlyUpdatesJamMasukWhenProvided(): void
    {
        $date = Time::today()->toDateString();
        
        $this->model->absenMasuk($this->testmemberId, $date, '07:00:00');
        $idPresensi = $this->model->cekAbsen($this->testmemberId, $date);
        
        // Update only jam_masuk
        $this->model->updatePresensi(
            $idPresensi,
            $this->testmemberId,
            $date,
            Kehadiran::Hadir->value,
            '06:30:00',
            null,
            ''
        );
        
        $presensi = $this->model->getPresensiById($idPresensi);
        
        $this->assertEquals('06:30:00', $presensi['jam_masuk']);
        $this->assertNull($presensi['jam_keluar']);
    }

    public function testUpdatePresensiOnlyUpdatesJamKeluarWhenProvided(): void
    {
        $date = Time::today()->toDateString();
        
        $this->model->absenMasuk($this->testmemberId, $date, '07:00:00');
        $idPresensi = $this->model->cekAbsen($this->testmemberId, $date);
        
        // Update only jam_keluar
        $this->model->updatePresensi(
            $idPresensi,
            $this->testmemberId,
            $date,
            Kehadiran::Hadir->value,
            null,
            '15:30:00',
            ''
        );
        
        $presensi = $this->model->getPresensiById($idPresensi);
        
        $this->assertEquals('07:00:00', $presensi['jam_masuk']);
        $this->assertEquals('15:30:00', $presensi['jam_keluar']);
    }

    public function testGetPresensiByKehadiranWithHadir(): void
    {
        $date = Time::today()->toDateString();
        
        $this->model->absenMasuk($this->testmemberId, $date, '07:00:00');
        
        $result = $this->model->getPresensiByKehadiran('1', $date);
        
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testGetPresensiByKehadiranWithTanpaKeterangan(): void
    {
        $date = Time::today()->toDateString();
        
        // Create teacher without attendance (considered as tanpa keterangan)
        
        $result = $this->model->getPresensiByKehadiran('4', $date);
        
        $this->assertIsArray($result);
    }
}
