<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CampaignOneTest extends TestCase
{
    /**
     * Test if a campaign with ID 1 exists
     *
     * @return void
     */
    public function test_campaignOneExists()
    {
        $row = DB::table('campaigns')->select('id')->get()->first();

        $this->assertEquals($row->id, 1);
    }

    /**
     * Test if spring discount campaign is 15 percent off
     *
     * @return void
     */
    public function test_campaignOneDiscountRateIs_15_percents()
    {
        $row = DB::table('campaigns')->select('discount')->get()->first();

        $this->assertEquals($row->discount, 15);
    }

}
