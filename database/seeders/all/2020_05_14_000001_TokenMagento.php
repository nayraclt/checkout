<?php

use \Raiadrogasil\Configuration\Domain\Entities\Configuration;
use \Raiadrogasil\Common\Enum\EnumStore;
use \Raiadrogasil\Configuration\Util\Enum\EnumTypeConfiguration;
use \Eighty8\LaravelSeeder\Migration\MigratableSeeder;
use \Eighty8\LaravelSeeder\Repository\DisableForeignKeysTrait;
use \Raiadrogasil\Token\Util\Enum\EnumConfiguration;
use \Illuminate\Support\Facades\DB;

class TokenMagento extends MigratableSeeder
{
    use DisableForeignKeysTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $typeConnection = Configuration::typeConnectionToConfiguration();

        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP_MAGENTO,
            'name_identify' => EnumConfiguration::CONSUMER_KEY,
            'name' => 'Consumer Key',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::PASSWORD,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP_MAGENTO,
            'name_identify' => EnumConfiguration::BY_PASS_TOKEN_MAGENTO,
            'name' => 'Utilizar ou nao a utilização do Token',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::BOOLEAN,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP_MAGENTO,
            'name_identify' => EnumConfiguration::CONSUMER_SECRET,
            'name' => 'Consumer Secret',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::PASSWORD,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);


        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP_MAGENTO,
            'name_identify' => EnumConfiguration::ACCESS_TOKEN,
            'name' => 'Access Token',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::PASSWORD,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP_MAGENTO,
            'name_identify' => EnumConfiguration::ACCESS_TOKEN_SECRET,
            'name' => 'Access Token Secret',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::PASSWORD,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }


    public function down(): void
    {
        $typeConnection = Configuration::typeConnectionToConfiguration();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP_MAGENTO)
            ->where('name_identify', EnumConfiguration::CONSUMER_KEY)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP_MAGENTO)
            ->where('name_identify', EnumConfiguration::BY_PASS_TOKEN_MAGENTO)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP_MAGENTO)
            ->where('name_identify', EnumConfiguration::CONSUMER_SECRET)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP_MAGENTO)
            ->where('name_identify', EnumConfiguration::ACCESS_TOKEN)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP_MAGENTO)
            ->where('name_identify', EnumConfiguration::ACCESS_TOKEN_SECRET)
            ->delete();
    }
}
