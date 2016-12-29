<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use DateTime;
class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data=array(   
            'hostmaster'        =>array(
                'name'=>'Host master',
                'value'=>'powerapi.devhub.vn'),
            'api_port'          =>array(
                'name'=>'Port',
                'value'=>8081),
            'zonepath'         =>array(
                'name'=>'Zone path',
                'value'=>'api/v1/servers/localhost/zones'),   
            'api_protocol'      =>array(
                'name'=>'Protocol',
                'value'=>'http'),
            'api_key'           =>    array(
                'name'=>'Api key',
                'value'=>''),
            
            'api_sslverify'     =>array(
                'name'=>'SSL Verify',
                'value'=>'FALSE'),
           /* 'api_allowzoneadd'     =>array(
                'name'=>'Allow add Zone',
                'value'=>'FALSE'),
            'api_logging'       =>array(
                'name'=>'Api login',
                'value'=>'TRUE'),
                */
            'ns1'               =>array(
                'name'=>'The value of the first NS-record',
                'value'=>'ns1.novaweb.vn'),
            'ns2'                =>array(
                'name'=>'The value of the second NS-record',
                'value'=>'ns2.novaweb.vn'),
            'hostmaster_record_soa'                =>array(
                'name'=>'Hostmaster record',
                'value'=>'hostmaster.novaweb.vn'),
           /* 'serial'             =>array(
                'name'=>'Serial',
                'value'=>date("Ymd").'00'),*/
            /*'ttl'               =>array(
                'name'=>'Default TTL for records',
                'value'=>3600),*/
            //'text'              =>array(
               // 'name'=>'Default value add New domain',
               // 'value'=>'28800 7200 604800 86400'),
            );
        $data=serialize($data);
        DB::table('settings')->insert([
            'key'		=>	'apiaccess',
            'value'		=>	$data,
            'created_at' => date('Y-m-d h:i:s',time()),
            ]);
        
    }
}
