<?php

use Illuminate\Database\Seeder;
class ShopOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_options')->insert([
            ['meta_key' => 'main_color', 'meta_value' => '#1f373d'],
            ['meta_key' => 'secondary_color', 'meta_value' => '#162831'],
            ['meta_key' => 'third_color', 'meta_value' => '#19cefb'],
            ['meta_key' => 'fourth_color', 'meta_value' => '#ffffff'],
            ['meta_key' => 'text_color', 'meta_value' => '#b4b8b9'],
            ['meta_key' => 'paypal_email', 'meta_value' => ''],
            ['meta_key' => 'embed_width', 'meta_value' => '1170'],
            ['meta_key' => 'embed_height', 'meta_value' => '800'],
            ['meta_key' => 'logo_path', 'meta_value' => ''],
            ['meta_key' => 'beat_thumbnail_path', 'meta_value' => ''],
            ['meta_key' => 'thank_you_page', 'meta_value' => '<p><strong><span style="font-size: 24pt; color: #19cefb;">THANK YOU FOR USING TRANSACTION MUSIC</span></strong></p>
            <p><span style="font-size: 24pt; color: #19cefb;">&nbsp;</span></p>
            <p><span style="color: #1f373d; font-size: 18pt;">Lorem ipsum &nbsp;dolor sit amet, consectetur adipisicing elit. Architecto distinctio esse fuga optioratione rem ut veniam? Aspernatur ea eveniet fuga illo libero <br />officia quisquam, rem repellat soluta vitae voluptate.<br /></span></p>
            <p><span style="color: #1f373d; font-size: 18pt;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br />Architecto distinctio esse fuga optio<br />ratione rem ut veniam? Aspernatur ea eveniet fuga illo libero <br />officia quisquam, rem repellat soluta<br />vitae voluptate.</span><br /><br /><br /> <span style="color: #1f373d; font-size: 18pt;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br />Architecto distinctio esse fuga optio<br />ratione rem ut veniam </span> <span style="color: #1f373d; font-size: 18pt;">&nbsp;</span></p>
            <p><span style="color: #1f373d; font-size: 18pt;">&nbsp;</span></p>
            <p><span style="color: #1f373d; font-size: 18pt;">Download link of your beats are sent on <span class="custom-mail-text" style="color: #20cffb;">%s</span> and will be available in next 24 hours</span></p>'],
            ['meta_key' => 'email_content', 'meta_value' => '<p><strong><span style="font-size: 24pt; color: #19cefb;">THANK YOU FOR USING TRANSACTION MUSIC</span></strong></p>
            <p><span style="font-size: 24pt; color: #19cefb;">&nbsp;</span></p>
            <p><span style="color: #1f373d; font-size: 18pt;">Lorem ipsum &nbsp;dolor sit amet, consectetur adipisicing elit. Architecto distinctio esse fuga optioratione rem ut veniam? Aspernatur ea eveniet fuga illo libero <br />officia quisquam, rem repellat soluta vitae voluptate.<br /></span></p>
            <p><span style="color: #1f373d; font-size: 18pt;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br />Architecto distinctio esse fuga optio<br />ratione rem ut veniam? Aspernatur ea eveniet fuga illo libero <br />officia quisquam, rem repellat soluta<br />vitae voluptate.</span><br /><br /><br /> <span style="color: #1f373d; font-size: 18pt;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br />Architecto distinctio esse fuga optio<br />ratione rem ut veniam </span> <span style="color: #1f373d; font-size: 18pt;">&nbsp;</span></p>
            <p><span style="color: #1f373d; font-size: 18pt;">&nbsp;</span></p>
            <p><span style="color: #1f373d; font-size: 18pt;">Download link of your beats are sent on <span class="custom-mail-text" style="color: #20cffb;">%s</span> and will be available in next 24 hours</span></p>'],
            ['meta_key' => 'url', 'meta_value' => url('/') ],
            ['meta_key' => 'instance_active', 'meta_value' => 0],
            ['meta_key' => 'instance_storage', 'meta_value' => 1],
        ]);
    }
}
