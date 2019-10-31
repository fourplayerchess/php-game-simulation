<?php declare(strict_types=1);
/**
 * PHP Game Simulation - Simulate 4 player chess games through PHP code.
 *
 * @license (https://www.fsf.org/) GNU General Public License v3.0.
 *          (https://github.com/fourplayerchess/php-game-simulation/blob/master/LICENSE)
 *
 * Permissions of this strong copyleft license are conditioned on making available complete source code
 * of licensed works and modifications, which include larger works using a licensed work, under the same license.
 * Copyright and license notices must be preserved. Contributors provide an express grant of patent rights.
 *
 * @package fourplayerchess/php-game-simulation.
 */

namespace FourPlayerChess\Test;

use FourPlayerChess\Helper;

use PHPUnit\Framework\TestCase;

/**
 * Test helper functionality.
 */
class HelperTest extends TestCase
{

    /**
     * @return void Returns nothing.
     */
    public function testNextColorFunction(): void
    {
        $helper = new Helper();
        $try = ['R' => 'B', 'B' => 'Y', 'Y' => 'G', 'G' => 'R'];
        foreach ($try as $color => $newColor) {
            $nextColor = $helper->nextColor($color);
            $this->assertTrue($nextColor == $newColor);
        }
    }

    /**
     * @return void Returns nothing.
     */
    public function testEnpassantFunctions(): void
    {
        $helper = new Helper();
        $enpassants = $helper->getEnpassant();
        $this->assertTrue($enpassants == ['R' => '-', 'B' => '-', 'Y' => '-', 'G' => '-',]);
        $helper->setEnpassant('R', 'A');
        $helper->setEnpassant('B', 'B');
        $helper->setEnpassant('Y', 'C');
        $helper->setEnpassant('G', 'D');
        $enpassants = $helper->getEnpassant();
        $this->assertTrue($enpassants == ['R' => 'A', 'B' => 'B', 'Y' => 'C', 'G' => 'D',]);
        $helper->optimizeEnpassant('R');
        $helper->optimizeEnpassant('B');
        $helper->optimizeEnpassant('Y');
        $helper->optimizeEnpassant('G');
        $enpassants = $helper->getEnpassant();
        $this->assertTrue($enpassants == ['R' => '-', 'B' => '-', 'Y' => '-', 'G' => '-',]);
    }

    /**
     * @return void Returns nothing.
     */
    public function testSquareFunctions(): void
    {
        $helper = new Helper();
        $badSquares = [
            'a1',  'a2',  'a3',  'b1',  'b2',  'b3',  'c1',  'c2',  'c3',
            'a14', 'a13', 'a12', 'b14', 'b13', 'b12', 'c14', 'c13', 'c12',
            'l1',  'l2',  'l3',  'm1',  'm2',  'm3',  'n1',  'n2',  'n3',
            'l14', 'l13', 'l12', 'm14', 'm13', 'm12', 'n14', 'n13', 'n12',
        ];
        $goodSquares = [
                                 'd14', 'e14', 'f14', 'g14', 'h14', 'i14', 'j14', 'k14',
                                 'd13', 'e13', 'f13', 'g13', 'h13', 'i13', 'j13', 'k13',
                                 'd12', 'e12', 'f12', 'g12', 'h12', 'i12', 'j12', 'k12',
            'a11', 'b11', 'c11', 'd11', 'e11', 'f11', 'g11', 'h11', 'i11', 'j11', 'k11', 'l11', 'm11', 'n11',
            'a10', 'b10', 'c10', 'd10', 'e10', 'f10', 'g10', 'h10', 'i10', 'j10', 'k10', 'l10', 'm10', 'n10',
            'a9',  'b9',  'c9',  'd9',  'e9',  'f9',  'g9',  'h9',  'i9',  'j9',  'k9',  'l9',  'm9',  'n9',
            'a8',  'b8',  'c8',  'd8',  'e8',  'f8',  'g8',  'h8',  'i8',  'j8',  'k8',  'l8',  'm8',  'n8',
            'a7',  'b7',  'c7',  'd7',  'e7',  'f7',  'g7',  'h7',  'i7',  'j7',  'k7',  'l7',  'm7',  'n7',
            'a6',  'b6',  'c6',  'd6',  'e6',  'f6',  'g6',  'h6',  'i6',  'j6',  'k6',  'l6',  'm6',  'n6',
            'a5',  'b5',  'c5',  'd5',  'e5',  'f5',  'g5',  'h5',  'i5',  'j5',  'k5',  'l5',  'm5',  'n5',
            'a4',  'b4',  'c4',  'd4',  'e4',  'f4',  'g4',  'h4',  'i4',  'j4',  'k4',  'l4',  'm4',  'n4',
                                 'd3',  'e3',  'f3',  'g3',  'h3',  'i3',  'j3',  'k3',
                                 'd2',  'e2',  'f2',  'g2',  'h2',  'i2',  'j2',  'k2',
                                 'd1',  'e1',  'f1',  'g1',  'h1',  'i1',  'j1',  'k1',
        ];
        $emptySquares = [
            'd12', 'e12', 'f12', 'g12', 'h12', 'i12', 'j12', 'k12',
            'c11', 'd11', 'e11', 'f11', 'g11', 'h11', 'i11', 'j11', 'k11', 'l11',
            'c10', 'd10', 'e10', 'f10', 'g10', 'h10', 'i10', 'j10', 'k10', 'l10',
            'c9',  'd9',  'e9',  'f9',  'g9',  'h9',  'i9',  'j9',  'k9',  'l9',
            'c8',  'd8',  'e8',  'f8',  'g8',  'h8',  'i8',  'j8',  'k8',  'l8',
            'c7',  'd7',  'e7',  'f7',  'g7',  'h7',  'i7',  'j7',  'k7',  'l7',
            'c6',  'd6',  'e6',  'f6',  'g6',  'h6',  'i6',  'j6',  'k6',  'l6',
            'c5',  'd5',  'e5',  'f5',  'g5',  'h5',  'i5',  'j5',  'k5',  'l5',
            'c4',  'd4',  'e4',  'f4',  'g4',  'h4',  'i4',  'j4',  'k4',  'l4',
            'd3',  'e3',  'f3',  'g3',  'h3',  'i3',  'j3',  'k3',
        ];
        foreach ($badSquares as $badSquare) {
            $this->assertTrue(!($helper->isNotOffBoardSquare($badSquare)));
        }
        foreach ($goodSquares as $goodSquare) {
            $this->assertTrue((\is_int($helper->isNotOffBoardSquare($goodSquare)) || \is_array($helper->isNotOffBoardSquare($goodSquare))));
            $res = \in_array($goodSquare, $emptySquares) ? $helper->isEmptySquare($goodSquare) : !$helper->isEmptySquare($goodSquare);
            $this->assertTrue($res);
        }
        $info1 = $helper->getSquareInfo('d14');
        $info2 = $helper->getSquareInfo('n11');
        $info3 = $helper->getSquareInfo('a4');
        $info4 = $helper->getSquareInfo('k1');
        $this->assertTrue($info1['color'] == 'Y');
        $this->assertTrue($info2['color'] == 'G');
        $this->assertTrue($info3['color'] == 'B');
        $this->assertTrue($info4['color'] == 'R');
        $this->assertTrue($info1['piece'] == 'R');
        $this->assertTrue($info2['piece'] == 'R');
        $this->assertTrue($info3['piece'] == 'R');
        $this->assertTrue($info4['piece'] == 'R');
        $info5 = $helper->getSquareInfo('f9');
        $info6 = $helper->getSquareInfo('g9');
        $info7 = $helper->getSquareInfo('h9');
        $info8 = $helper->getSquareInfo('i9');
        $this->assertTrue($info5['color'] == \null);
        $this->assertTrue($info6['color'] == \null);
        $this->assertTrue($info7['color'] == \null);
        $this->assertTrue($info8['color'] == \null);
        $this->assertTrue($info5['piece'] == \null);
        $this->assertTrue($info6['piece'] == \null);
        $this->assertTrue($info7['piece'] == \null);
        $this->assertTrue($info8['piece'] == \null);
        $info9 = $helper->getSquareInfo('a1');
        $info10 = $helper->getSquareInfo('a2');
        $info11 = $helper->getSquareInfo('a3');
        $info12 = $helper->getSquareInfo('c1');
        $this->assertTrue(!$info9);
        $this->assertTrue(!$info10);
        $this->assertTrue(!$info11);
        $this->assertTrue(!$info12);
    }

    /**
     * @return void Returns nothing.
     */
    public function testThreatFunctions(): void
    {
        $helper = new Helper();
        $data = [
            'a8' => [
                'a9' => \true,
                'b8' => \true,
                'a7' => \true,
                'c8' => \false,
                'c9' => \false,
            ],
            'h1' => [
                'g1' => \true,
                'i1' => \true,
                'h2' => \true,
                'i3' => \false,
                'h3' => \false,
            ],
            'g14' => [
                'g13' => \true,
                'f14' => \true,
                'h14' => \true,
                'f12' => \false,
                'h12' => \false,
            ],
            'n7' => [
                'n6' => \true,
                'n8' => \true,
                'm7' => \true,
                'm5' => \false,
                'n5' => \false,
                'a7' => \false,
            ],
        ];
        foreach ($data as $from => $info) {
            foreach ($info as $to => $res) {
                $isThreat = $helper->isKingThreat($from, $to);
                $this->assertTrue($res == $isThreat);
            }
        }
        $data = [
            'a4' => [
                'b4' => \true,
                'a5' => \true,
                'l4' => \false,
                'a7' => \false,
                'a6' => \false,
            ],
            'k14' => [
                'k13' => \true,
                'j14' => \true,
                'j13' => \false,
                'f14' => \false,
                'k3'  => \false,
            ],
            'n4' => [
                'n5' => \true,
                'm4' => \true,
                'm5' => \false,
                'c4' => \false,
                'n8' => \false,
            ],
            'k1' => [
                'j1'  => \true,
                'k2'  => \true,
                'k3'  => \false,
                'k12' => \false,
                'd1'  => \false,
            ],
            'd4' => [
                'd11' => \true,
                'k4'  => \true,
                'd14' => \false,
                'n4'  => \false,
            ],
            'k11' => [
                'k4'  => \true,
                'd11' => \true,
                'k1'  => \false,
                'a11' => \false,
            ],
        ];
        foreach ($data as $from => $info) {
            foreach ($info as $to => $res) {
                $isThreat = $helper->isRookThreat($from, $to);
                $this->assertTrue($res == $isThreat);
            }
        }
        $data = [
            'b4' => [
                'a5'  => \true,
                'k13' => \true,
                'd2'  => \false,
                'c4'  => \false,
                'a6'  => \false,
            ],
            'k2' => [
                'b11' => \true,
                'j1'  => \true,
                'm4'  => \false,
                'b4'  => \false,
                'd2'  => \false,
            ],
            'm11' => [
                'd2'  => \true,
                'n10' => \true,
                'k13' => \false,
                'c4'  => \false,
                'm4'  => \false,
            ],
            'd13' => [
                'e14' => \true,
                'm4'  => \true,
                'b11' => \false,
                'b8'  => \false,
                'b7'  => \false,
            ],
        ];
        foreach ($data as $from => $info) {
            foreach ($info as $to => $res) {
                $isThreat = $helper->isBishopThreat($from, $to);
                $this->assertTrue($res == $isThreat);
            }
        }
        $data = [
            'a5' => [
                'c4' => \true,
                'c6' => \true,
                'b7' => \true,
                'c7' => \false,
                'd5' => \false,
            ],
            'e14' => [
                'd12' => \true,
                'f12' => \true,
                'g13' => \true,
                'g12' => \false,
                'f8'  => \false,
            ],
            'n5' => [
                'l4' => \true,
                'l6' => \true,
                'm7' => \true,
                'm8' => \false,
                'n8' => \false,
            ],
            'j1' => [
                'k3' => \true,
                'i3' => \true,
                'h2' => \true,
                'h3' => \false,
                'h4' => \false,
            ],
        ];
        foreach ($data as $from => $info) {
            foreach ($info as $to => $res) {
                $isThreat = $helper->isKnightThreat($from, $to);
                $this->assertTrue($res == $isThreat);
            }
        }
        $data = [
            'b6' => [
                'c7' => \true,
                'c5' => \true,
                'c6' => \false,
                'a7' => \false,
                'a5' => \false,
            ],
            'f13' => [
                'e12' => \true,
                'g12' => \true,
                'f12' => \false,
                'e14' => \false,
                'g14' => \false,
            ],
            'h2' => [
                'i3' => \true,
                'g3' => \true,
                'h3' => \false,
                'i1' => \false,
                'g1' => \false,
            ],
            'm7' => [
                'l8' => \true,
                'l6' => \true,
                'l7' => \false,
                'n8' => \false,
                'n6' => \false,
            ],
        ];
        foreach ($data as $from => $info) {
            foreach ($info as $to => $res) {
                $isThreat = $helper->isPawnThreat($from, $to, \false);
                $this->assertTrue($res == $isThreat);
            }
        }
    }
}
