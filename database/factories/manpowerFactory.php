<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\manpower>
 */
class manpowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $jobArea=[
            "Mining",
            "Hauling",
            "Port",
            "-"
        ];
        $grade=[
            "L1","L2","L3","L4","L5","L6","L7","L8","L9","L10","-"
        ];
        $status=[
            "AKTIF",
            "TIDAK AKTIF"
        ];
        return [
            "nrp"=>mt_rand(80000001,80001234),
            "nama"=>fake()->name(),
            "perusahaan"=>fake()->company(),
            "jabatanStr"=>fake()->jobTitle(),
            "jabatanFn"=>fake()->jobTitle(),
            "tempatLahir"=>fake()->city(),
            "noTelp1"=>fake()->e164PhoneNumber(),
            "noTelp2"=>fake()->e164PhoneNumber(),
            "remark"=>fake()->text(20),
            "jobArea"=>$jobArea[mt_rand(0,2)],
            "grade"=>$grade[mt_rand(0,10)],
            "status"=>$status[mt_rand(0,1)],
            "noMinePermit"=>"MP/SIS-".mt_rand(0000000,9999999),
            "email"=>fake()->freeEmail(),
            "about"=>fake()->realText(200,3)

        ];
    }
}
