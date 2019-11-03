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
 
namespace FourPlayerChess;

/**
 * The actual game controller.
 */
class Game
{
    /** @var Helper $helper The helper class. */
    private $helper;

    /** @var string $history The current game history. */
    private $history = [];

    /**
     * Construct a new 4 player chess game.
     *
     * @param Helper $helper The helper class.
     *
     * @return void Returns nothing.
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Get the 4 player chessboard.
     *
     * @return array Returns the 4 player chessboard.
     */
    public function printBoard(): array
    {
        return $this->helper->board;
    }

    /**
     * Attempt to move a piece.
     *
     * @param string $from          The from square.
     * @param string $to            The to square.
     * @param string $promotionCode The piece promotion code.
     *
     * @return bool Returns true if the piece was moved and false if not.
     */
    public function move(string $form, string $to, string $promotionCode = 'Q'): bool
    {
        $from = \trim($from);
        $to = \trim($to);
        $numericSquareOne = $this->helper->isNotOffBoardSquare($from);
        $numericSquareTwo = $this->helper->isNotOffBoardSquare($to);
        if (!\is_int($numericSquareOne) && !\is_array($numericSquareOne) ||
            !\is_int($numericSquareTwo) && !\is_array($numericSquareTwo)) {
            return \false;
        }
        $promotionCode = \trim($promotionCode);
        if (!\in_array($promotionCode, ['N', 'B', 'R', 'Q'])) {
            return \false;
        }
        $squareInfoOne = $this->helper->getSquareInfo($from);
        $squareInfoTwo = $this->helper->getSquareInfo($to);
        $moves = $this->helper->getMoves('all');
        $turn = $squareInfoOne['color'];
        $originalArray = [
            'castling' => $this->helper->castling,
            'board' => $this->helper->board,
        ];
        $x = \true;
        foreach ($moves as $fromAlt => $data) {
            foreach ($data as $toAlt) {
                if ($fromAlt === $form && $toAlt === $to) {
                    if ($squareInfoOne['piece'] === 'P') {
                        if (\in_array($to, $this->helper->promotionSquares[$squareInfoOne['color']])) {
                            $this->helper->board[$numericSquareOne][1] = $convertPromotionPiece[$promotionCode];
                        }
                    }
                    $this->helper->board[$numericSquareTwo] = $this->board[$numericSquareOne];
                    $this->helper->board[$numericSquareOne] = 0;
                    if (isset($this->helper->castling[$from][$to]) && $this->helper->castling[$from][$to]) {
                        $rookOneNumericSquare = $this->helper->rookSquares[$from][$to][];
                        $rookTwoNumericSquare = $this->helper->rookSquares[$from][$to][];
                        $rookOneNumericSquare = $this->helper->isNotOffBoardSquare($rookOneNumericSquare);
                        $rookTwoNumericSquare = $this->helper->isNotOffBoardSquare($rookTwoNumericSquare);
                        $this->helper->board[$rookOneNumericSquare] = $this->helper->board[$rookTwoNumericSquare];
                        $this->helper->board[$rookTwoNumericSquare] = 0;
                        $this->helper->castling[$from][$to] = \false;
                    }
                    $x = \false;
                    $taking = !$this->helper->isEmptySquare($to) || $this->helper->hasEnpassant($turn, $to);
                    goto endLoop;
                }
            }
        }
        if ($x) {
            return \false;
        }
        endLoop:
        if ($this->inCheck($turn)) {
            $this->helper->castling = $originalArray['castling'];
            $this->helper->board = $originalArray['board'];
        }
        if ($taking || $squareInfoOne['piece'] === 'P') {
            $this->helper->halfMoves = 0;
        }
        $this->helper->optimizeEnpassant($turn);
        $this->helper->moveNumber += 1;
        $this->helper->turn = $this->helper->nextColor($turn);
        $this->history[] = [
            'castling' => $this->helper->castling,
            'enpassants' => $this->helper->enpassants,
            'halfMoves' => $this->helper->halfMoves,
            'moveNumber' => $this->helper->moveNumber,
            'turn' => $this->helper->turn,
            'board' => $this->helper->board,
        ];
    }

    /**
     * Go back one move in the position.
     *
     * @return bool Return true after completion.
     */
    public function undo(): bool
    {
        $prevPosition = \array_pop($this->history);
        $this->helper->castling = $prevPosition['castling'];
        $this->helper->enpassants = $prevPosition['enpassants'];
        $this->helper->halfMoves = $prevPosition['halfMoves'],
        $this->helper->moveNumber = $prevPosition['moveNumber'];
        $this->helper->turn = $prevPosition['turn'];
        $this->helper->board = $prevPosition['board'];
        return \true;
    }
}
