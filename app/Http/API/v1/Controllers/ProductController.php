<?php

namespace App\Http\API\v1\Controllers;

use App\Http\Controllers\Controller;
use App\Http\API\v1\Resources\ProductCollection;
use App\Http\API\v1\Resources\ProductResource;
use App\Http\API\v1\Requests\ProductRequest;
use App\Services\ProductServiceInterface;
use Raiadrogasil\Common\Traits\RestActions;

class ProductController extends Controller
{
    use RestActions;

    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param $resource
     * @return ProductResource
     * @codeCoverageIgnore
     */
    protected function resource($resource)
    {
        return new ProductResource($resource);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/checkout/product",
     *     tags={"Product v1"},
     *     summary="Retorna os valores dos produtos indicados",
     *     description="Retorna multiplos registros",
     *     operationId="Product_all",
     *     @OA\Parameter(
     *         name="storeName",
     *         in="path",
     *         description="Nome da loja [DROGARAIA, DROGASIL, ONOFRE]",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sku",
     *         in="query",
     *         description="SKUs de busca. Ex: SKU",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="zipcode",
     *         in="query",
     *         description="Zipcode",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="qty",
     *         in="query",
     *         description="Quantity",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso na operação",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                    property="results",
     *                    type="object",
     *                    @OA\Property(
     *                         property="price",
     *                         type="object",
     *                         @OA\Property(
     *                            property="sku",
     *                            description="SKU do produto",
     *                            type="integer",
     *                            example=888
     *                         ),
     *                         @OA\Property(
     *                             property="valueFrom",
     *                             description="Valor inicial do produto",
     *                             type="number",
     *                             example=25.5
     *                         ),
     *                         @OA\Property(
     *                             property="valueTo",
     *                             description="Valor final do produto",
     *                             type="number",
     *                             example=14.02
     *                         )
     *                    ),
     *                    @OA\Property(
     *                         property="stock",
     *                         type="object",
     *                         @OA\Property(
     *                            property="sku",
     *                            description="SKU do produto",
     *                            type="integer",
     *                            example=888
     *                         ),
     *                         @OA\Property(
     *                             property="qty",
     *                             description="Quantidade de estoque do produto",
     *                             type="integer",
     *                             example=11861
     *                         ),
     *                    ),
     *                    @OA\Property(
     *                         property="quoteShipping",
     *                         type="object",
     *                         @OA\Property(
     *                            property="value",
     *                            description="Valor do frete",
     *                            type="number",
     *                            example=9.73
     *                         ),
     *                         @OA\Property(
     *                             property="baseCost",
     *                             description="Custo base da entrega",
     *                             type="number",
     *                             example=9.73
     *                         ),
     *                         @OA\Property(
     *                             property="flow",
     *                             description="Flow",
     *                             type="string",
     *                             example="CD"
     *                         ),
     *                         @OA\Property(
     *                             property="id",
     *                             description="ID da entrega",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="estimateDays",
     *                             description="Dias estimados para entrega",
     *                             type="integer",
     *                             example=2
     *                         ),
     *                         @OA\Property(
     *                             property="idSubsidiary",
     *                             description="ID subisidiário",
     *                             type="integer",
     *                             example=3077
     *                         ),
     *                         @OA\Property(
     *                             property="origin",
     *                             description="Origem",
     *                             type="string",
     *                             example="intelipost"
     *                         ),
     *                         @OA\Property(
     *                             property="label",
     *                             type="object",
     *                             @OA\Property(
     *                                  property="default",
     *                                  description="Label default",
     *                                  type="string",
     *                                  example="Rápida"
     *                             ),
     *                             @OA\Property(
     *                                  property="deadline",
     *                                  description="Label deadline",
     *                                  type="string",
     *                                  example="Rápida - 2 dia(s) útil(eis)"
     *                             ),
     *                             @OA\Property(
     *                                  property="success",
     *                                  description="Label success",
     *                                  type="string",
     *                                  example="Rápida - 2 dia(s) útil(eis)"
     *                             ),
     *                             @OA\Property(
     *                                  property="informative",
     *                                  description="Label informative",
     *                                  type="string",
     *                                  example="Entrega 1 dia útil"
     *                             ),
     *                         ),
     *                         @OA\Property(
     *                             property="oms",
     *                             description="Dados de integração com o OMS",
     *                             type="object",
     *                             @OA\Property(
     *                                  property="carrier",
     *                                  description="Carrier",
     *                                  type="integer",
     *                                  example=1
     *                             ),
     *                             @OA\Property(
     *                                  property="service",
     *                                  description="Service",
     *                                  type="integer",
     *                                  example=2
     *                             ),
     *                         ),
     *                         @OA\Property(
     *                             property="shiftDelivery",
     *                             description="Shift delivery",
     *                             type="array",
     *                             @OA\Items(
     *                                  type="object",
     *                                  @OA\Property(
     *                                      property="active",
     *                                      description="Status do registro",
     *                                      type="integer",
     *                                      example=1
     *                                  ),
     *                                  @OA\Property(
     *                                      property="text",
     *                                      description="Label da entrega",
     *                                      type="string",
     *                                      example="Manhã (Entre 08h e 12h)"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="nextDay",
     *                                      description="Label da entrega",
     *                                      type="integer",
     *                                      example=1
     *                                  ),
     *                                  @OA\Property(
     *                                      property="uptake",
     *                                      description="Label da entrega",
     *                                      type="string",
     *                                      format="date",
     *                                      example="23:34"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="deliveryFrom",
     *                                      description="Label da entrega",
     *                                      type="string",
     *                                      format="date",
     *                                      example="08:34"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="deliveryTo",
     *                                      description="Label da entrega",
     *                                      type="string",
     *                                      format="date",
     *                                      example="11:34"
     *                                  ),
     *                             )
     *                         ),
     *                         @OA\Property(
     *                             property="information",
     *                             description="Texto informativo a respeito do frete",
     *                             type="string",
     *                             example="Compre mais R$ 440 e ganhe frete grátis  para a região Sudeste e Centro Oeste."
     *                         ),
     *                         @OA\Property(
     *                             property="scheduledDelivery",
     *                             description="Informa que o tipo da entrega é agendado",
     *                             type="boolean",
     *                             example=false
     *                         ),
     *                      )
     *                 ),
     *                 @OA\Property(
     *                    property="traceId",
     *                    type="string",
     *                    description="Id da transacao",
     *                    type="string",
     *                    example="7fa5fb8cad53cff1ff0149100d278ee3"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Valor inválido na operação",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                      type="object",
     *                      @OA\Property(
     *                          property="message",
     *                          description="Mensagem retornada",
     *                          type="string",
     *                          example="Os dados fornecidos são inválidos"
     *                      ),
     *                      @OA\Property(
     *                         property="traceId",
     *                         type="string",
     *                         description="Id da transacao",
     *                         type="string",
     *                         example="7fa5fb8cad53cff1ff0149100d278ee3"
     *                      ),
     *                      @OA\Property(
     *                         property="trace",
     *                         type="string",
     *                         description="Trace do problema",
     *                         type="string",
     *                         example=""
     *                      )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro não encotrado",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                      type="object",
     *                      @OA\Property(
     *                          property="message",
     *                          description="Mensagem retornada",
     *                          type="string",
     *                          example="Registro não encontrado"
     *                      ),
     *                      @OA\Property(
     *                         property="traceId",
     *                         type="string",
     *                         description="Id da transação",
     *                         type="string",
     *                         example="7fa5fb8cad53cff1ff0149100d278ee3"
     *                      ),
     *                      @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         description="Descrição do erro",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="trace",
     *                         type="string",
     *                         description="Trace do problema",
     *                         type="string",
     *                         example=""
     *                      )
     *             )
     *         )
     *     )
     * )
     */
    public function all($storeName, ProductRequest $request)
    {
        $productDTO = $request->validateFind($storeName);

        try {
            $dataProduct = $this->productService->allCheckoutData($productDTO);
        } catch (\Throwable $e) {
            throw $e;
        }

        $config = null;
        if (!empty($dataProduct)) {
            $config = $this->resource($dataProduct)->configureMainParser();
        }

        return $this->response($config);
    }
}
