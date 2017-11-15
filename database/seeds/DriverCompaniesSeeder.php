<?php

use Illuminate\Database\Seeder;
use App\Models\DriverCompany;

class DriverCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = array(
        'PT. INDUK SULMAPA KEKAR' => 'ASRUL TINAI',
        'PT. PRATAMA MITRA SEJATI' => 'ACHMAD AFFANDI'
      );

      foreach ($data as $company_name => $director) {
        $dc = DriverCompany::create([
          'company_name' => $company_name,
          'company_director' => $director
        ]);
      }
    }
}
