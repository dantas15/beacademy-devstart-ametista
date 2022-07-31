<?php

namespace Database\Factories;

use Faker\Generator;
use Faker\Provider\pt_BR\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = new Generator();
        $faker->addProvider(new Address($faker));

        $cityPrefix = Address::cityPrefix();
        $citySuffix = Address::citySuffix();

        $brUf = array(
            'AC', // =>'Acre',
            'AL', // =>'Alagoas',
            'AP', // =>'Amapá',
            'AM', // =>'Amazonas',
            'BA', // =>'Bahia',
            'CE', // =>'Ceará',
            'DF', // =>'Distrito Federal',
            'ES', // =>'Espírito Santo',
            'GO', // =>'Goiás',
            'MA', // =>'Maranhão',
            'MT', // =>'Mato Grosso',
            'MS', // =>'Mato Grosso do Sul',
            'MG', // =>'Minas Gerais',
            'PA', // =>'Pará',
            'PB', // =>'Paraíba',
            'PR', // =>'Paraná',
            'PE', // =>'Pernambuco',
            'PI', // =>'Piauí',
            'RJ', // =>'Rio de Janeiro',
            'RN', // =>'Rio Grande do Norte',
            'RS', // =>'Rio Grande do Sul',
            'RO', // =>'Rondônia',
            'RR', // =>'Roraima',
            'SC', // =>'Santa Catarina',
            'SP', // =>'São Paulo',
            'SE', // =>'Sergipe',
            'TO', // =>'Tocantins'
        );

        return [
            'id' => Str::uuid(),
            'zip' => Address::postcode(),
            'uf' => $brUf[array_rand($brUf)],
            'city' => "$cityPrefix $citySuffix",
            'street' => $this->faker->sentence(4),
            'number' => $this->faker->numerify(),
            'neighborhood' => $this->faker->sentence(3),
            'complement' => null,
            'user_id' => User::factory(),
        ];
    }
}
