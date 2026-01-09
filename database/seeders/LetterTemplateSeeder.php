<?php

namespace Database\Seeders;

use App\Models\LetterTemplate;
use Illuminate\Database\Seeder;

class LetterTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'code' => 'SKD',
                'name' => 'Surat Keterangan Domisili',
                'description' => 'Surat keterangan yang menyatakan bahwa seseorang berdomisili di wilayah desa',
                'content' => $this->getSkdTemplate(),
            ],
            [
                'code' => 'SKCK',
                'name' => 'Surat Pengantar SKCK',
                'description' => 'Surat pengantar untuk pembuatan SKCK di kepolisian',
                'content' => $this->getSkckTemplate(),
            ],
            [
                'code' => 'SKU',
                'name' => 'Surat Keterangan Usaha',
                'description' => 'Surat keterangan yang menyatakan bahwa seseorang memiliki usaha di wilayah desa',
                'content' => $this->getSkuTemplate(),
            ],
            [
                'code' => 'SKTM',
                'name' => 'Surat Keterangan Tidak Mampu',
                'description' => 'Surat keterangan yang menyatakan bahwa seseorang termasuk keluarga tidak mampu',
                'content' => $this->getSktmTemplate(),
            ],
            [
                'code' => 'SKP',
                'name' => 'Surat Keterangan Pindah',
                'description' => 'Surat keterangan untuk keperluan pindah domisili',
                'content' => $this->getSkpTemplate(),
            ],
        ];

        foreach ($templates as $template) {
            LetterTemplate::updateOrCreate(
                ['code' => $template['code']],
                $template
            );
        }
    }

    private function getSkdTemplate(): string
    {
        return <<<'HTML'
<div style="font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h3 style="margin: 0;">PEMERINTAH DESA</h3>
        <h2 style="margin: 5px 0; text-decoration: underline;">SURAT KETERANGAN DOMISILI</h2>
        <p style="margin: 0;">Nomor: {{nomor_surat}}</p>
    </div>

    <p>Yang bertanda tangan di bawah ini, Kepala Desa menerangkan bahwa:</p>

    <table style="margin: 20px 0 20px 40px;">
        <tr><td style="width: 150px;">Nama</td><td>: {{nama}}</td></tr>
        <tr><td>NIK</td><td>: {{nik}}</td></tr>
        <tr><td>Tempat/Tgl Lahir</td><td>: {{tempat_lahir}}, {{tanggal_lahir}}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {{jenis_kelamin}}</td></tr>
        <tr><td>Agama</td><td>: {{agama}}</td></tr>
        <tr><td>Pekerjaan</td><td>: {{pekerjaan}}</td></tr>
        <tr><td>Alamat</td><td>: {{alamat}}</td></tr>
    </table>

    <p>Adalah benar warga yang berdomisili di wilayah kami.</p>
    <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{keperluan}}</strong></p>
    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

    <div style="margin-top: 40px; display: flex; justify-content: space-between;">
        <div style="text-align: center; width: 200px;">
            {{qr_code}}
            <p style="font-size: 8pt; margin-top: 5px;">Scan untuk verifikasi</p>
        </div>
        <div style="text-align: center;">
            <p>{{tanggal_surat}}</p>
            <p>Kepala Desa</p>
            <br><br><br>
            <p style="text-decoration: underline;">_____________________</p>
        </div>
    </div>
</div>
HTML;
    }

    private function getSkckTemplate(): string
    {
        return <<<'HTML'
<div style="font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h3 style="margin: 0;">PEMERINTAH DESA</h3>
        <h2 style="margin: 5px 0; text-decoration: underline;">SURAT PENGANTAR SKCK</h2>
        <p style="margin: 0;">Nomor: {{nomor_surat}}</p>
    </div>

    <p>Yang bertanda tangan di bawah ini, Kepala Desa menerangkan bahwa:</p>

    <table style="margin: 20px 0 20px 40px;">
        <tr><td style="width: 150px;">Nama</td><td>: {{nama}}</td></tr>
        <tr><td>NIK</td><td>: {{nik}}</td></tr>
        <tr><td>Tempat/Tgl Lahir</td><td>: {{tempat_lahir}}, {{tanggal_lahir}}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {{jenis_kelamin}}</td></tr>
        <tr><td>Agama</td><td>: {{agama}}</td></tr>
        <tr><td>Pekerjaan</td><td>: {{pekerjaan}}</td></tr>
        <tr><td>Alamat</td><td>: {{alamat}}</td></tr>
    </table>

    <p>Adalah benar warga kami yang berkelakuan baik dan tidak pernah terlibat dalam tindak pidana/kriminal.</p>
    <p>Surat pengantar ini dibuat untuk keperluan: <strong>{{keperluan}}</strong></p>
    <p>Demikian surat pengantar ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

    <div style="margin-top: 40px; display: flex; justify-content: space-between;">
        <div style="text-align: center; width: 200px;">
            {{qr_code}}
            <p style="font-size: 8pt; margin-top: 5px;">Scan untuk verifikasi</p>
        </div>
        <div style="text-align: center;">
            <p>{{tanggal_surat}}</p>
            <p>Kepala Desa</p>
            <br><br><br>
            <p style="text-decoration: underline;">_____________________</p>
        </div>
    </div>
</div>
HTML;
    }

    private function getSkuTemplate(): string
    {
        return <<<'HTML'
<div style="font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h3 style="margin: 0;">PEMERINTAH DESA</h3>
        <h2 style="margin: 5px 0; text-decoration: underline;">SURAT KETERANGAN USAHA</h2>
        <p style="margin: 0;">Nomor: {{nomor_surat}}</p>
    </div>

    <p>Yang bertanda tangan di bawah ini, Kepala Desa menerangkan bahwa:</p>

    <table style="margin: 20px 0 20px 40px;">
        <tr><td style="width: 150px;">Nama</td><td>: {{nama}}</td></tr>
        <tr><td>NIK</td><td>: {{nik}}</td></tr>
        <tr><td>Tempat/Tgl Lahir</td><td>: {{tempat_lahir}}, {{tanggal_lahir}}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {{jenis_kelamin}}</td></tr>
        <tr><td>Alamat</td><td>: {{alamat}}</td></tr>
    </table>

    <p>Adalah benar warga kami yang memiliki usaha di wilayah desa kami.</p>
    <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{keperluan}}</strong></p>
    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

    <div style="margin-top: 40px; display: flex; justify-content: space-between;">
        <div style="text-align: center; width: 200px;">
            {{qr_code}}
            <p style="font-size: 8pt; margin-top: 5px;">Scan untuk verifikasi</p>
        </div>
        <div style="text-align: center;">
            <p>{{tanggal_surat}}</p>
            <p>Kepala Desa</p>
            <br><br><br>
            <p style="text-decoration: underline;">_____________________</p>
        </div>
    </div>
</div>
HTML;
    }

    private function getSktmTemplate(): string
    {
        return <<<'HTML'
<div style="font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h3 style="margin: 0;">PEMERINTAH DESA</h3>
        <h2 style="margin: 5px 0; text-decoration: underline;">SURAT KETERANGAN TIDAK MAMPU</h2>
        <p style="margin: 0;">Nomor: {{nomor_surat}}</p>
    </div>

    <p>Yang bertanda tangan di bawah ini, Kepala Desa menerangkan bahwa:</p>

    <table style="margin: 20px 0 20px 40px;">
        <tr><td style="width: 150px;">Nama</td><td>: {{nama}}</td></tr>
        <tr><td>NIK</td><td>: {{nik}}</td></tr>
        <tr><td>Tempat/Tgl Lahir</td><td>: {{tempat_lahir}}, {{tanggal_lahir}}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {{jenis_kelamin}}</td></tr>
        <tr><td>Agama</td><td>: {{agama}}</td></tr>
        <tr><td>Pekerjaan</td><td>: {{pekerjaan}}</td></tr>
        <tr><td>Alamat</td><td>: {{alamat}}</td></tr>
    </table>

    <p>Adalah benar warga kami yang termasuk dalam kategori keluarga tidak mampu/kurang mampu.</p>
    <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{keperluan}}</strong></p>
    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

    <div style="margin-top: 40px; display: flex; justify-content: space-between;">
        <div style="text-align: center; width: 200px;">
            {{qr_code}}
            <p style="font-size: 8pt; margin-top: 5px;">Scan untuk verifikasi</p>
        </div>
        <div style="text-align: center;">
            <p>{{tanggal_surat}}</p>
            <p>Kepala Desa</p>
            <br><br><br>
            <p style="text-decoration: underline;">_____________________</p>
        </div>
    </div>
</div>
HTML;
    }

    private function getSkpTemplate(): string
    {
        return <<<'HTML'
<div style="font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h3 style="margin: 0;">PEMERINTAH DESA</h3>
        <h2 style="margin: 5px 0; text-decoration: underline;">SURAT KETERANGAN PINDAH</h2>
        <p style="margin: 0;">Nomor: {{nomor_surat}}</p>
    </div>

    <p>Yang bertanda tangan di bawah ini, Kepala Desa menerangkan bahwa:</p>

    <table style="margin: 20px 0 20px 40px;">
        <tr><td style="width: 150px;">Nama</td><td>: {{nama}}</td></tr>
        <tr><td>NIK</td><td>: {{nik}}</td></tr>
        <tr><td>Tempat/Tgl Lahir</td><td>: {{tempat_lahir}}, {{tanggal_lahir}}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {{jenis_kelamin}}</td></tr>
        <tr><td>Agama</td><td>: {{agama}}</td></tr>
        <tr><td>Pekerjaan</td><td>: {{pekerjaan}}</td></tr>
        <tr><td>Alamat Asal</td><td>: {{alamat}}</td></tr>
    </table>

    <p>Bermaksud pindah untuk keperluan: <strong>{{keperluan}}</strong></p>
    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

    <div style="margin-top: 40px; display: flex; justify-content: space-between;">
        <div style="text-align: center; width: 200px;">
            {{qr_code}}
            <p style="font-size: 8pt; margin-top: 5px;">Scan untuk verifikasi</p>
        </div>
        <div style="text-align: center;">
            <p>{{tanggal_surat}}</p>
            <p>Kepala Desa</p>
            <br><br><br>
            <p style="text-decoration: underline;">_____________________</p>
        </div>
    </div>
</div>
HTML;
    }
}
