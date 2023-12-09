<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\kodeTraining;
use App\Models\training;
use App\Models\perusahaan;
use App\Models\section;
use App\Models\jobArea;
use App\Models\subSection;
use App\Models\jabatanStruktural;
use App\Models\JabatanFungsional;
use App\Models\uraianMateri;
use App\Models\lokasiTraining;
use App\Models\lembagaTraining;
use App\Models\instructor;
use App\Models\kodeKompetensi;
use App\Models\targetOji;
use App\Models\manpower;
use App\Models\ojiReport;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();
        manpower::create([
            'about'=>'Dia seorang kestria dari timur yang berbadan tegap dan penuh dengan kewibawaan',
            'nrp'=>'80001234',
            'noMinePermit'=>'MP/SIS-20210123',
            'nama'=>'Joko Prasetyo',
            'perusahaan'=>"PT. SIS",
            'jobArea'=>"Hauling",
            'section'=>"PLANT",
            'subSection'=>"Plant Hauling",
            'jabatanStr'=>"Group Leader",
            'jabatanFn'=>"Group Leader - Plant Hauling",
            'spesialis'=>"-",
            'grade'=>"-",
            'jointDate'=>"1990/01/01",
            'tempatLahir'=>"Malang",
            'tanggalLahir'=>"1990/01/02",
            'noTelp1'=>"081208334556",
            'noTelp2'=>"08122334566",
            'email'=>"joko@jomblo.com",
            'status'=>"AKTIF",
            'remark'=>"Keren"

        ]);  
        
        manpower::create([
            'about'=>'Dia seorang kestria dari timur yang berbadan tegap dan penuh dengan kewibawaan',
            'nrp'=>'80001235',
            'noMinePermit'=>'MP/SIS-20210124',
            'nama'=>'Bejo Subejo',
            'perusahaan'=>"PT. SIS",
            'jobArea'=>"Hauling",
            'section'=>"PLANT",
            'subSection'=>"Plant Hauling",
            'jabatanStr'=>"Group Leader",
            'jabatanFn'=>"Group Leader - Plant Hauling",
            'spesialis'=>"-",
            'grade'=>"-",
            'jointDate'=>"1990/01/01",
            'tempatLahir'=>"Malang",
            'tanggalLahir'=>"1990/01/02",
            'noTelp1'=>"081208334556",
            'noTelp2'=>"08122334566",
            'email'=>"bejojuga@jomblo.com",
            'status'=>"AKTIF",
            'remark'=>"Keren"

        ]); 
        
        


        kodeTraining::create([
            'kode'=>'2AD0001',
            'judul'=>'ADD AIR CONDITIONER',
            'trainingPrefix'=>'ADD',
            'spesialis'=>'-'
        ]);

        kodeTraining::create([
            'kode'=>'2MT0008',
            'judul'=>'MTS DZ KOMATSU D155A-6',
            'trainingPrefix'=>'MTS',
            'spesialis'=>'DZ-K'
        ]);

        kodeTraining::create([
            'kode'=>'2PK0113',
            'judul'=>'PK BULDOZER KOMATSU D375A-6R',
            'trainingPrefix'=>'PK',
            'spesialis'=>'DZ-K'
        ]);

        kodeTraining::create([
            'kode'=>'2PM0113',
            'judul'=>'PM BULDOZER KOMATSU D375A-6R',
            'trainingPrefix'=>'PM',
            'spesialis'=>'DZ-K'
        ]);

        // training::create([
        //     'nrp'=>'00113187',
        //     'idTr'=>'1',
        //     'kodeTr'=>'2PM0113',
        //     'uraianMateri'=>'bekerja dengan isolasi',
        //     'lokasi'=>'MACO/Haju',
        //     'lembaga'=>'test',
        //     'instructor'=>'test',
        //     'category'=>'test',
        //     'programTraining'=>'test',
        //     'hardSoft'=>'test',
        //     'start'=>'2023/01/01',
        //     'end'=>'2023/10/10',
        //     'remark'=>'lkasjdlkasdlkaj'
        // ]);
        // training::create([
        //     'nrp'=>'00113187',
        //     'idTr'=>'2',
        //     'kodeTr'=>'2PK0113',
        //     'uraianMateri'=>'preventive maintenance liebherr',
        //     'lokasi'=>'test',
        //     'lembaga'=>'test',
        //     'instructor'=>'Singspro',
        //     'category'=>'test',
        //     'programTraining'=>'test',
        //     'hardSoft'=>'test',
        //     'start'=>'2023/02/02',
        //     'end'=>'2023/11/11',
        //     'remark'=>'lkasjdlkasdlkaj'
        // ]);
        // training::create([
        //     'nrp'=>'00113187',
        //     'idTr'=>'3',
        //     'kodeTr'=>'2MT0008',
        //     'uraianMateri'=>'product liebherr',
        //     'lokasi'=>'test',
        //     'lembaga'=>'test',
        //     'instructor'=>'test',
        //     'category'=>'test',
        //     'programTraining'=>'test',
        //     'hardSoft'=>'test',
        //     'start'=>'2023/03/03',
        //     'end'=>'2023/12/12',
        //     'remark'=>'lkasjdlkasdlkaj'
        // ]);

        perusahaan::create([
            'perusahaan'=>'PT. Saptaindra Sejati',
            'abrevation'=>'PT. SIS'
        ]);
        perusahaan::create([
            'perusahaan'=>'PT. Maruwai Coal',
            'abrevation'=>'PT. MC'
        ]);

        section::create(
            [
                'section'=>'PLANT',
            ]
            );

        
        section::create(
            [
                'section'=>'HRGA',
            ]
            );
        section::create(
            [
                'section'=>'-',
            ]
            );

        jobArea::create([
            'jobArea'=>'MINING'
        ]);

        jobArea::create([
            'jobArea'=>'HAULING'
        ]);

        jobArea::create([
            'jobArea'=>'PORT'
        ]);

        jobArea::create([
            'jobArea'=>'-'
        ]);

        subSection::create([
            'subSection'=>'WHEEL'
        ]);
        subSection::create([
            'subSection'=>'PLANT HAULING'
        ]);

        jabatanStruktural::create([
            'jabatanStruktural'=>'MECHANIC'
        ]);
        jabatanStruktural::create([
            'jabatanStruktural'=>'GROUP LEADER'
        ]);
        jabatanStruktural::create([
            'jabatanStruktural'=>'UNIT HEAD'
        ]);

        jabatanFungsional::create([
            'jabatanFungsional'=>'MECHANIC-PLANT HAULING'
        ]);
        jabatanFungsional::create([
            'jabatanFungsional'=>'MECHANIC-WHEEL'
        ]);
        jabatanFungsional::create([
            'jabatanFungsional'=>'TRACK'
        ]);

        uraianMateri::create([
            'uraianMateri'=>'Bekerja dengan isolasi'
        ]);
        uraianMateri::create([
            'uraianMateri'=>'liebherr'
        ]);

        lokasiTraining::create([
            'lokasiTraining'=>'MACO-Hauling'
        ]);

        lokasiTraining::create([
            'lokasiTraining'=>'MACO-Mining'
        ]);

        lembagaTraining::create([
            'lembaga'=>'PPD MACO'
        ]);

        instructor::create([
            'namaInstructor'=>'Onga'
        ]);

//--------------------------------------------------------------------------//
        kodeKompetensi::create([
            'kode'=>'061.01-2.A-EX-K',
            'namaKompetensi'=>'Bekerja dengan aman',
            'unitSpcl'=>'ALL',
            'point'=>10
        ]);

        kodeKompetensi::create([
            'kode'=>'061.01-2.A-EX-L',
            'namaKompetensi'=>'HOT HOT POP',
            'unitSpcl'=>'ALL',
            'point'=>10
        ]);

        kodeKompetensi::create([
            'kode'=>'061.01-2.A-EX-C',
            'namaKompetensi'=>'ENAK BANGET',
            'unitSpcl'=>'ALL',
            'point'=>10
        ]);

        kodeKompetensi::create([
            'kode'=>'020.03-1.A-CT-V',
            'namaKompetensi'=>'Periodic Service 250 HM',
            'unitSpcl'=>'CT-V',
            'point'=>10
        ]);

        kodeKompetensi::create([
            'kode'=>'020.03-1.A-HP-M',
            'namaKompetensi'=>'Periodic Service 250 HM',
            'unitSpcl'=>'HP-M',
            'point'=>10
        ]);

//--------------------------------------------------------------------------//

        targetOji::create([
            'idOji'=>'80001234_061.01-2.A-EX-K_2023',
            'nrp'=>'80001234',
            'kodeKompetensi'=>'061.01-2.A-EX-K',
            'tahun'=>2023,
            'jenisOji'=>'MANDATORY'
        ]);

        targetOji::create([
            'idOji'=>'80001234_061.01-2.A-EX-L_2023',
            'nrp'=>'80001234',
            'kodeKompetensi'=>'061.01-2.A-EX-L',
            'tahun'=>2023,
            'jenisOji'=>'MANDATORY'
        ]);

        targetOji::create([
            'idOji'=>'80001234_061.01-2.A-EX-C_2023',
            'nrp'=>'80001234',
            'kodeKompetensi'=>'061.01-2.A-EX-C',
            'tahun'=>2023,
            'jenisOji'=>'MANDATORY'
        ]);

        targetOji::create([
            'idOji'=>'80001234_020.03-1.A-HP-M_2023',
            'nrp'=>'80001234',
            'kodeKompetensi'=>'020.03-1.A-HP-M',
            'tahun'=>2023,
            'jenisOji'=>'VERIFIKASI'
        ]);

        targetOji::create([
            'idOji'=>'80001235_061.01-2.A-EX-K_2023',
            'nrp'=>'80001235',
            'kodeKompetensi'=>'061.01-2.A-EX-K',
            'tahun'=>2023,
            'jenisOji'=>'MANDATORY'
        ]);

        targetOji::create([
            'idOji'=>'80001235_061.01-2.A-EX-L_2023',
            'nrp'=>'80001235',
            'kodeKompetensi'=>'061.01-2.A-EX-L',
            'tahun'=>2023,
            'jenisOji'=>'MANDATORY'
        ]);


        ojiReport::create([
            'idOji'=>'80001234_061.01-2.A-EX-K_2023',
            'nrp'=>'80001234',
            'kodeKompetensi'=>'061.01-2.A-EX-K',
            'startDate'=>'2023/06/01',
            'endDate'=>'2023/06/01',
            'startTime'=>'07:00',
            'endTime'=>'09:00',
            'instructor'=>1,
            'jenisOji'=>'MANDATORY',
            'remark'=>'oji ini khusus guys'
        ]);


    }
}
