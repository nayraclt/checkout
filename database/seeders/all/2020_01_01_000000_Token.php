<?php

use \Raiadrogasil\Configuration\Domain\Entities\Configuration;
use \Raiadrogasil\Common\Enum\EnumStore;
use \Raiadrogasil\Configuration\Util\Enum\EnumTypeConfiguration;
use \Eighty8\LaravelSeeder\Migration\MigratableSeeder;
use \Eighty8\LaravelSeeder\Repository\DisableForeignKeysTrait;
use \Raiadrogasil\Token\Util\Enum\EnumConfiguration;
use \Illuminate\Support\Facades\DB;

class Token extends MigratableSeeder
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
            'name_group' => EnumConfiguration::TOKEN_GROUP,
            'name_identify' => EnumConfiguration::TOKEN_USER,
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
            'name_group' => EnumConfiguration::TOKEN_GROUP,
            'name_identify' => EnumConfiguration::TOKEN_PASSWORD,
            'name' => 'Senha de conexão com OMS',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::PASSWORD,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        //user token old
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP,
            'name_identify' => EnumConfiguration::TOKEN_USER_OLD,
            'name' => 'Usuário de conexão com integrações antigas',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::STRING,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        //password token old
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP,
            'name_identify' => EnumConfiguration::TOKEN_PASSWORD_OLD,
            'name' => 'Senha de conexão com integrações antigas',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::PASSWORD,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);


        //livetime token
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP,
            'name_identify' => EnumConfiguration::TOKEN_LIVETIME,
            'name' => 'Tempo de vida do TOKEN (em segundos)',
            'value' => 86400,
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::NUMBER,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        //uri token
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP,
            'name_identify' => EnumConfiguration::TOKEN_URI_API,
            'name' => 'Caminho da API',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::STRING,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        //uri token old
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP,
            'name_identify' => EnumConfiguration::TOKEN_URI_API_OLD,
            'name' => 'Caminho da API com integrações antigas',
            'value' => '',
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::STRING,
            'channel_site' => 1,
            'channel_tlv' => 1,
            'channel_app' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        //ativate log api
        DB::connection($typeConnection)->table(Configuration::TABLE)->insert([
            'name_group' => EnumConfiguration::TOKEN_GROUP,
            'name_identify' => EnumConfiguration::ACTIVATE_LOG_API,
            'name' => 'Ativar/Desativar o LOG de API ao buscar o TOKEN',
            'value' => 1,
            'name_store' => EnumStore::ALL_STORES,
            'type_configuration' => EnumTypeConfiguration::BOOLEAN,
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
            ->where('name_group', EnumConfiguration::TOKEN_GROUP)
            ->where('name_identify', EnumConfiguration::TOKEN_USER)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP)
            ->where('name_identify', EnumConfiguration::TOKEN_PASSWORD)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP)
            ->where('name_identify', EnumConfiguration::TOKEN_USER_OLD)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP)
            ->where('name_identify', EnumConfiguration::TOKEN_PASSWORD_OLD)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP)
            ->where('name_identify', EnumConfiguration::TOKEN_LIVETIME)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP)
            ->where('name_identify', EnumConfiguration::TOKEN_URI_API)
            ->delete();

        DB::table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP)
            ->where('name_identify', EnumConfiguration::TOKEN_URI_API_OLD)
            ->delete();

        DB::connection($typeConnection)->table(Configuration::TABLE)
            ->where('name_group', EnumConfiguration::TOKEN_GROUP)
            ->where('name_identify', EnumConfiguration::ACTIVATE_LOG_API)
            ->delete();
    }
}
