<?php

use \Raiadrogasil\Configuration\Domain\Entities\Configuration;
use \Raiadrogasil\Common\Enum\EnumStore;
use \Raiadrogasil\Configuration\Util\Enum\EnumTypeConfiguration;
use \Eighty8\LaravelSeeder\Migration\MigratableSeeder;
use \Eighty8\LaravelSeeder\Repository\DisableForeignKeysTrait;
use \Raiadrogasil\Token\Util\Enum\EnumConfiguration;
use \Illuminate\Support\Facades\DB;

class TokenMsShipping extends MigratableSeeder
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

        //user token
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP_MS_SHIPPING,
            'name_identify' => EnumConfiguration::TOKEN_USER_MS,
            'name' => 'Usuário de conexão com OMS',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::STRING,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        //password token
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP_MS_SHIPPING,
            'name_identify' => EnumConfiguration::TOKEN_PASSWORD_MS,
            'name' => 'Senha de conexão com OMS',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::PASSWORD,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        //uri token
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP_MS_SHIPPING,
            'name_identify' => EnumConfiguration::TOKEN_URI_API_MS,
            'name' => 'Caminho da API',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::STRING,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        //escop do token
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP_MS_SHIPPING,
            'name_identify' => EnumConfiguration::TOKEN_SCOPE_MS,
            'name' => 'Escopo do token [write, read]',
            'value' => 'write',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::STRING,
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
            ->where('name_group', EnumConfiguration::TOKEN_GROUP_MS_SHIPPING)
            ->where('name_identify', EnumConfiguration::TOKEN_USER_MS)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP_MS_SHIPPING)
            ->where('name_identify', EnumConfiguration::TOKEN_PASSWORD_MS)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP_MS_SHIPPING)
            ->where('name_identify', EnumConfiguration::TOKEN_URI_API_MS)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP_MS_SHIPPING)
            ->where('name_identify', EnumConfiguration::TOKEN_SCOPE_MS)
            ->delete();
    }
}
