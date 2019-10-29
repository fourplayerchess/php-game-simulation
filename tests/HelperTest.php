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
}
