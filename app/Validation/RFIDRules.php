<?php

namespace App\Validation;

use App\Models\SiswaModel;
use App\Models\memberModel;

class RFIDRules
{
    /**
     * Checks if an RFID code is unique across tb_siswa and tb_member.
     * Use as: is_rfid_unique[exclude_id,type]
     * Example: is_rfid_unique[1,siswa] or is_rfid_unique[,siswa]
     */
    public function is_rfid_unique(string $str, string $fields, array $data, &$error = null): bool
    {
        if (empty($str)) {
            return true;
        }

        $params = explode(',', $fields);
        $excludeId = $params[0] ?? null;
        $type = $params[1] ?? null;

        $siswaModel = new SiswaModel();
        $memberModel = new memberModel();

        // Check in tb_siswa
        $siswaQuery = $siswaModel->where('rfid_code', $str);
        if ($type === 'siswa' && !empty($excludeId)) {
            $siswaQuery->where('id_siswa !=', $excludeId);
        }
        if ($siswaQuery->countAllResults() > 0) {
            $error = 'RFID code ini sudah digunakan oleh Siswa.';
            return false;
        }

        // Check in tb_member
        $memberQuery = $memberModel->where('rfid_code', $str);
        if ($type === 'member' && !empty($excludeId)) {
            $memberQuery->where('id_member !=', $excludeId);
        }
        if ($memberQuery->countAllResults() > 0) {
            $error = 'RFID code ini sudah digunakan oleh member.';
            return false;
        }

        return true;
    }
}
