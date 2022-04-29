<!DOCTYPE html>
<html lang="en">
<?php include_once "views/header.php" ?>
<?php include_once "php/histori.php" ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-4 p-2 text-center"><button type="button" class="btn btn-success btn-lg" <?php echo !isset($_SESSION['logged']) ? 'disabled="true"' : '' ?> onclick="newCard()">NEW GAME</button></div>
        <div class="col-lg-4 p-2 text-center"><button type="button" class="btn btn-info btn-lg" <?php echo !isset($_SESSION['logged']) ? 'disabled="true"' : '' ?> data-toggle="modal" data-target="#recargeModal">RECHARGE ACCOUNT</button></div>
        <div class="col-lg-4 p-2 text-center"><button type="button" class="btn btn-dark btn-lg" <?php echo !isset($_SESSION['logged']) ? 'disabled="true"' : '' ?> data-toggle="modal" data-target="#historyModal">GAMES HISTORY</button></div>

    </div>
</div>
<div class="container mt-4 bg-light border rounded p-4">

    <h4 class="text-center text-uppercase font-underline" id="tabellone">Ready to try your luck?</h4>
    <div class="row mt-4 mb-4 borderYellow">
        <div class="col text-center">
            <div id="mainNumbersContainer">
                
            </div>
        </div>
    </div>
    <hr><hr>
    <div class="row mt-4 d-flex justify-content-center">
        <div class="col"></div>
        <div class="col-lg-5 d-flex justify-content-center align-items-center card border">
            <div id="numberContainer"></div>
        </div>
        <div class="col-lg-6">
            <div class="row mt-5">
                <div class="col-md-6 text-right divgame"><button type="button" class="btn btn-warning font-weight-bold" onclick="populateCard()">CHANGE CARD</button></div>
                <div class="col-md-6 text-left divgame"><button type="button" class="btn btn-success font-weight-bold" onclick="startGame()">START GAME</button></div>
            </div>
            <div class="row mt-5">
                <div class="col mb-4"><h5 id="errors" class="text-center">Before starting the game you have to bet!</h5></div>
            </div>
            <div class="row">
                <div class="col"><h5 id="errors" class="text-center font-weight-bold">How many you bet?</h5></div>
            </div>
            <div class="row mt-2">
                <div class="col col-xs-4 text-right divbetbutton"><button type="button" class="btn btn-primary btn-lg rounded-circle p-4 betButton" onclick="checkCredits(1, this)">1€</button></div>
                <div class="col col-xs-4 text-center divbetbutton"><button type="button" class="btn btn-primary btn-lg rounded-circle p-4 betButton" onclick="checkCredits(2, this)">2€</button></div>
                <div class="col col-xs-4 text-left divbetbutton"><button type="button" class="btn btn-primary btn-lg rounded-circle p-4 betButton" onclick="checkCredits(5, this)">5€</button></div>    
            </div>
        </div>
        <!-- <div class="col"></div> -->
      </div>
</div>
</div>
</div>

<!-- Modal history -->
<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Your Game History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table>
                    <thead>
                        <tr class="border-bottom">
                            <th class="text-center"><b>DATE</b></th>
                            <th class="text-center"><b>BET</b></th>
                            <th class="text-center"><b>RESULT</b></th>
                            <th class="text-center"><b>WIN</b></th>
                        </tr>
                    </thead>
                    <tbody id="history">
                        
                        <?php if (isset($_SESSION['logged'])) : ?>
                            
                            <?php $games = history() ?>
                            
                            <?php foreach ($games as $game) : ?>
                                <tr>
                                    <td class="text-center pt-2">
                                        <h6><?php echo $game['date'] ?></h6>
                                    </td>
                                    <td class="text-center pt-2">
                                        <h6><?php echo $game['bet'] ?> €</h6>
                                    </td>
                                    <td class="text-center pt-2">
                                        <h6><?php echo $game['result'] ?></h6>
                                    </td>
                                    <td class="text-center pt-2">
                                        <h6><?php echo $game['win'] ?> €</h6>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
                <form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "views/footer.php" ?>