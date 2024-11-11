<?php

namespace Database\Seeders;

use App\Enums\EntryPortType;
use App\Models\EntryPort;
use Illuminate\Database\Seeder;

class EntryPortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            EntryPortType::AIR_PORT->value => [
                'Noi Bai airport - Hanoi city (HAN)',
                'Tan Son Nhat airport - Ho Chi Minh city (SGN)',
                'Cam Ranh airport - Nha Trang city (CXR)',
                'Da Nang airport - Da Nang city (DAD)',
                'Cat Bi airport - Haiphong city (HPH)',
                'Can Tho airport - Can Tho city (VCA)',
                'Phu Quoc airport - Phu Quoc Island (PQC)',
                'Phu Bai airport - Hue city (HUI)',
                'Van Don airport - Quang Ninh province (VDO)',
                'Tho Xuan airport - Thanh Hoa province (THD)',
                'Dong Hoi airport - Quang Binh province (VDH)',
                'Phu Cat airport - Binh Dinh province (UIH)',
                'Lien Khuong airport - Da Lat city (DLI)'
            ],

            EntryPortType::LAND_PORT->value => [
                'Tay Trang landport',
                'Mong Cai landport',
                'Huu Nghi landport',
                'Lao Cai landport',
                'Na Meo landport',
                'Nam Can landport',
                'Cau Treo landport',
                'Cha Lo landport',
                'La Lay landport',
                'Lao Bao landport',
                'Bo Y landport',
                'Moc Bai landport',
                'Xa Mat landport',
                'Tinh Bien landport',
                'Vinh Xuong landport',
                'Ha Tien landport'
            ],

            EntryPortType::SEA_PORT->value => [
                'Hon Gai port (VNHON)',
                'Cam Pha port (VNCPH)',
                'Hai Phong port (VNHPH)',
                'Nghi Son port (VNNGH)',
                'Vung Ang port (VNVAG)',
                'Chan May port (VNCMY)',
                'Da Nang port (VNDAD)',
                'Nha Trang port (VNNHA)',
                'Quy Nhon port (VNUIH)',
                'Dung Quat port (VNDQT)',
                'Vung Tau port (VNVUT)',
                'Ho Chi Minh port (VNSGN)',
                'Duong Dong port (VNPQC)'
            ],
        ];

        foreach ($data as $type => $names) {
            foreach ($names as $name) {
                EntryPort::factory()->create([
                    'type' => $type,
                    'name' => $name
                ]);
            }
        }
    }
}
