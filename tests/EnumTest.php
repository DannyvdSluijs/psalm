<?php
namespace Psalm\Tests;

class EnumTest extends TestCase
{
    use Traits\ValidCodeAnalysisTestTrait;

    /**
     * @return iterable<string,array{string,assertions?:array<string,string>,error_levels?:string[]}>
     */
    public function providerValidCodeParse(): iterable
    {
        return [
            'example' => [
                '<?php
                    interface Colourful {
                        public function color(): string;
                    }

                    enum Suit implements Colourful {
                        case Hearts;
                        case Diamonds;
                        case Clubs;
                        case Spades;

                        public function color(): string {
                            return match($this) {
                                Suit::Hearts, Suit::Diamonds => "Red",
                                Suit::Clubs, Suit::Spaces => "Black",
                            };
                        }

                        public function shape(): string {
                            return "Rectangle";
                        }
                    }

                    function paint(Colourful $c): void {}

                    paint(Suit::Clubs);

                    Suit::Diamonds->shape();',
                [],
                [],
                '8.1'
            ],
        ];
    }
}
