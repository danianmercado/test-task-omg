<?php
namespace App\Services\ExternalApi;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalApiService implements ExternalApiInterface
{
    /**
     * @throws \Exception
     */
    public function fetchData(): array
    {
        try {
            $response = Http::get(env('EXCHANGE_URL'));

            if ($response->successful()) {

                return $this->parseExchangeRates($response->body());
            } else {
                Log::error('Failed to fetch exchange rates from the external API.');
                throw new \Exception('Failed to fetch exchange rates from the external API.');
            }
        } catch (\Exception $e) {
             Log::error($e->getMessage());
             throw $e;
        }
    }

    protected function parseExchangeRates($xmlData): array
    {
        try {
            $xml = json_decode(json_encode(simplexml_load_string($xmlData)), true);
            $values = $xml['Valute'];
            $data = [];
            foreach ($values as $value) {
                $data[] = [
                    'external_id'   => $value['@attributes']['ID'],
                    'num_code'      => $value['NumCode'],
                    'char_code'     => $value['CharCode'],
                    'nominal'       => $value['Nominal'],
                    'name'          => $value['Name'],
                    'value'         => (float)str_replace(',', '.', $value['Value']),
                    'v_unit_rate'   => (float)str_replace(',', '.', $value['VunitRate']),
                ];
            }
            return $data;
        } catch (\Exception $e) {
            Log::error("Error on parsing");
            throw $e;
        }

    }
}
