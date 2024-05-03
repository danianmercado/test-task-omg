<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\DataRepository;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

class CurrencyController extends Controller
{
    #[OAT\Get(path:'/v1/get-exchange-rates', operationId:'get-exchange-rates', summary:'Get exchange rates', tags:['Public'])]
    #[OAT\Response(response:200, description:'OK', content:new OAT\JsonContent(properties:[
        new OAT\Property(property:'status', type:'string', default:'success'),
        new OAT\Property(property:'data', type:'array', items:new OAT\Items(properties:[
            new OAT\Property(property:'external_id', type:'string', example: 'R01010'),
            new OAT\Property(property:'num_code', type:'string', example: '036'),
            new OAT\Property(property:'char_code', type:'string', example: 'AUD'),
            new OAT\Property(property:'nominal', type:'string', example: '1'),
            new OAT\Property(property:'name', type:'string', example: 'Австралийский доллар'),
            new OAT\Property(property:'value', type:'float', example: 60.324),
            new OAT\Property(property:'v_unit_rate', type:'float', example: 60.324),
        ], type:'object')),
    ], type:'object'))]
    #[OAT\Response(response:500, description:'Validation failed', content:new OAT\JsonContent(properties:[
        new OAT\Property(property:'status', type:'string', default:'error'),
        new OAT\Property(property:'message', type:'string', default:'An error occurred while fetching data', nullable:true),
    ], type:'object'))]
    public function getExchangeRates(DataRepository $dataRepository): JsonResponse
    {
        try {
            $data = $dataRepository->getData();
            return response()->json([
                'status' => 'success',
                'data'   => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred while fetching data.'
            ], 500);
        }
    }
}
