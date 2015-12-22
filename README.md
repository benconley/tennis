# tennis
# ArmorPayments coding challenge
Armor Payments is holding our annual ping-pong tournament, and fame, glory, and office braging rights are on the line! Unfortunately, we forgot to make a reservation to rent a ping-pong table, so we can't actually play ping-pong. Instead, we'd like your help in simulating the tournament.

We expect that this challenge can be completed quickly. In any event, please do not spend more than two hours on this. You may implement your solution in the language and environment of your choice. You are welcome to use any libraries you'd like.

The included `data.csv` file includes the details of each of the players. Your solution should read this data in from the file. If you are not familiar with file system operations, or if you are implementing your solution in a way that does not easily support file system operations, you may instead provide your solution with the same data in a more convenient format (for example, as a JSON object).

## Rules of the game
The tournament is round-robin, where each player plays each other player once. The first player to 11 points wins the game, and players alternate serving every two points. Once each player has played every other player, the player with the highest win/loss record wins the tournament.

### A single point
During each point, the following sequence occurs

1. The serving player serves the ball. That player's `serve_accuracy` statistic is the chance, as a percentage, that their serve will be in-bounds.
2. If the serve is not in-bounds, the other player scores a point, and the point ends.
3. If the serve is in-bounds, the other player attempts to return the ball. Their `return_skill` statistic is the chance, as a percentage, that they will successfully return the ball, and their `return_accuracy` statistic is the chance, as a percentage, that their return will be in-bounds.
4. If the receiving player does not return the ball, or if their return is not in-bounds, the other player scores a point, and the point ends.
5. If the receiving player returns the ball, the other player now becomes the receiving player, and this process continues until one player fails to successfully return the ball.

Once the point ends, your solution should report the new score of the game.

### Ending a game
Once one player reaches 11 points, the game is over, and your solution should report the winner and the new win/loss record of each player.

## Example output
Your solution will need to report on each point as it is played, and each point and game as they are completed. You may choose to present this output any way you like, but the following is an example of a simple text output.

    ...
    Mark serves to Dr. Claw... in-bounds
    Dr. Claw returns to Mark... in-bounds
    Mark returns to Dr. Claw... in-bounds
    Dr. Claw returns to Mark... in-bounds
    Mark fails to return.
    Dr. Claw gets a point!
    The score is Mark 8, Dr. Claw 11.
    Dr. Claw wins the game!
    Mark's record is now 0-1.
    Dr. Claw's record is now 1-0.
    
    Dr. Claw is playing O-Ren Ishii
    Dr. Claw serves to O-Ren Ishii... out of bounds
    O-Ren Ishii gets a point!
    The score is Dr. Claw 0, O-Ren Ishii 1.
    ...

## Extra credit
If you have some extra time, consider updating your implementation to include one or more of the following:

 * Implement a tie-breaker mechanic to handle the case where two players have the same win/loss record at the end of the tournament.
 * Put some spin on the ball! The data file includes fields for `serve_spin` and `return_spin` for each player. Subtract the appropriate spin statistic from the receiving player's `return_skill` statistic when determining if they are able to succesfully return the ball.
 * Look up the rules of [table tennis](https://en.wikipedia.org/wiki/Table_tennis) and implement a better simulation of the game. Some items you might try:
   * Require that a player win a game by at least two points (so a score of 10-11 would not end the game)
   * Do not allow a player to win on their own serve. If the next point would allow the serving player to win the game, switch the serve to the other player.
 * Do something nicer-looking than a basic text dump for output.

## Submitting your solution
Please include all necessary files, including your code, copies of any libraries you used, the data file, and this README in a ZIP file titled `armor-coding-challenge-[YOUR_FIRST_AND_LAST_INITIAL].zip`. Include any necessary instructions to run your solution. If you'd like to provide some additional context, a brief description of your solution, an explanation of why you selected the language/environment you did, and any trade-offs you made and why is welcome but not required.

