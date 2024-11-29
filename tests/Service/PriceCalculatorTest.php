<?php

declare(strict_types=1);


namespace App\Tests\Service;

use App\Dto\CalculatePriceDto;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\CouponType;
use PHPUnit\Framework\TestCase;
use Mockery;
use App\Service\PriceCalculator;
use App\Repository\ProductRepository;
use App\Repository\CouponRepository;
use App\Service\CountryResolver;

class PriceCalculatorTest extends TestCase
{
    private Mockery\MockInterface $productRepository;
    private Mockery\MockInterface $couponRepository;
    private PriceCalculator $priceCalculator;

    protected function setUp(): void
    {
        $this->productRepository = Mockery::mock(ProductRepository::class);
        $this->couponRepository = Mockery::mock(CouponRepository::class);

        $this->priceCalculator = new PriceCalculator(
            $this->productRepository,
            $this->couponRepository,
            new CountryResolver(),
        );
    }

    /**
     * @dataProvider priceCalculationDataProvider
     */
    public function testCalculatePriceWithDataProvider(
        int $id,
        string $name,
        string $taxNumber,
        string $couponCode,
        string $couponType,
        float $price,
        float $discount,
        float $expectedPrice,
    ) {
        $product = new Product($name, $price);
        $this->productRepository->shouldReceive('find')->with($id)->andReturn($product);

        $coupon = new Coupon($couponCode, CouponType::from($couponType), $discount);
        $this->couponRepository->shouldReceive('findOneBy')->with(['code' => $couponCode])->andReturn($coupon);

        $dto = new CalculatePriceDto($id, $taxNumber, $couponCode);
        $result = $this->priceCalculator->calculate($dto);
        
        $this->assertEquals($expectedPrice, $result->price);
    }

    public static function priceCalculationDataProvider(): array
    {
        return [
            [1, 'IPhone', 'DE123456789', 'D15', 'fixed', 100, 15, 104.0],
            [2, 'Наушники', 'IT12345678900', 'D20', 'percentage', 20, 20, 20.4],
            [3, 'Чехол', 'GR1234567890', 'D5', 'fixed', 10, 5, 7.4],
        ];
    }
}