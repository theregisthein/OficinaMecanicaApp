// Arquivo: frontend/database/seeders/DatabaseSeeder.php

<?php

use App\Models\Pessoa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Insere o usuário ADMIN com o hash BCrypt
        Pessoa::create([
            'nome' => 'Administrador',
            'email' => 'admin@oficina.com',
            'senha' => '123456',
            'perfil' => 'ADMIN',
            'endereco' => 'Rua Admin 123',
            'cpfcnpj' => '00000000000',
            'telefone' => '999999999',
            'tipo' => 'fisica',
        ]);

    }
}