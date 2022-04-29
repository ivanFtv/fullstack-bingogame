// FUNCTIONS FOR THE ACCOUNT PURPOSE 
//check if registering email already exist in DB ajax request
function checkEmail() {
    let thisEmail = document.getElementById('registerEmail').value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/api/checkemail.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("email=" + thisEmail);
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4) {
            //if exist put the warning message and disabled the subbit button
            if (xhr.responseText == 'true') {
                document.getElementById('emailHelp').className = '';
                document.getElementById('emailHelp').classList.add('text-danger');
                document.getElementById('emailHelp').innerText = "This email already exist!"
                document.getElementById('registerSubmit').disabled = 'true';
            } else if (xhr.responseText == 'false'){
                document.getElementById('emailHelp').className = '';
                document.getElementById('emailHelp').classList.add('text-success');
                document.getElementById('emailHelp').innerText = "Email available!"
                document.getElementById('registerSubmit').disabled = '';
            }
        }
    }
}

//check pass and confirm pass fields
function checkPass() {
    let pass = document.getElementById('registerPassword').value;
    let confirmPass = document.getElementById('registerPasswordConfirm').value;
    if (pass != confirmPass) {
        document.getElementById('passHelp').innerText = "Passwords not matched!";
        document.getElementById('registerSubmit').disabled = 'true';
    } else {
        document.getElementById('passHelp').innerText = "";
        document.getElementById('registerSubmit').disabled = '';
    }
}

//register ajax request
function register() {
    const thisEmail = document.getElementById('registerEmail').value;
    const thisFirstName = document.getElementById('registerFirstname').value;
    const thisLastName = document.getElementById('registerLastname').value;
    const thisUsername = document.getElementById('registerUsername').value;
    const thisPassword = document.getElementById('registerPassword').value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/api/register.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("firstname=" + thisFirstName + "&lastname=" + thisLastName + "&email=" + thisEmail + "&username=" + thisUsername + "&password=" + thisPassword);
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4) {
            if (xhr.responseText == 'true') {
                window.location.replace("index.php");
            } else {
                document.getElementById('registerHelp').innerText = 'Register Error!';
            }
        }
    };
}

//login ajax request
function login() {
    const thisUsername = document.getElementById('loginUsername').value;
    const thisPassword = document.getElementById('loginPassword').value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/api/login.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("username=" + thisUsername + "&password=" + thisPassword);
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4) {
            if (xhr.responseText == 'true') {
                window.location.replace("index.php");
            } else {
                document.getElementById('loginHelp').innerText = 'Login or Password not Correct';
            }
        }
    };
}

//logout ajax request
function logout() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/api/logout.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send();
    xhr.onreadystatechange = () => {
        if (xhr.responseText == 'true') {
            window.location.replace("index.php");
        } 
    }  
}

// FUNCTIONS FOR GAME PURPOSE 
//global vars
let money = 0; //bet of current game
let inGame = false; //for cheking if one game is in progress
let score = 0; //for memorize the type of winning
let win = 0; //memorize the amount won per game
let extractions = 30; //how many numbers are drawn per game
let totalNumbers = 90; //how many totals numbers

//generate main board
genBoard();

//set the user bet
function setMoney(value, div) {
    if (inGame) {
        let betButtons = document.querySelectorAll('.betSelected');
        betButtons.forEach(element => {
        element.classList.remove('betSelected');
        });
        if ( document.getElementById('credits').innerText == 0 || document.getElementById('credits').innerText == 'NaN') document.getElementById('errors').innerHTML = 'You have run out of money in your account';
        else if (document.getElementById('credits').innerText < value) document.getElementById('errors').innerHTML = 'You only have ' + value + 'Euro left in your account!';
        else {
            div.classList.add('betSelected');
            money = value;
            document.getElementById('errors').innerHTML = 'You have bet: <strong>'+money+' €</strong>!';
        }
    }
}

//reset the general game settings (call every new game)
function reset() {
    document.getElementById('numberContainer').innerHTML = '';
    document.getElementById('errors').innerHTML = 'New game created...';
    money = 0;
    score = 0;
    win = 0;
    let cardNumbers = document.querySelectorAll('.mainNumbers');
    cardNumbers.forEach(element => {
        element.classList.remove('extracted');
    });
    let betButtons = document.querySelectorAll('.betSelected');
    betButtons.forEach(element => {
        element.classList.remove('betSelected');
        });
}

//generate new card HTML structure dynamically
function newCard() {
    if (inGame == false) {
        reset();
        let container = document.getElementById('numberContainer');
        for (i=1; i<=15; i++) {
        let div = document.createElement('div');
        div.classList.add('number')
        div.setAttribute('data-number', i)
        container.appendChild(div)
        }
        inGame = true;
        populateCard();
    }
}

//populate the card with 15 random numbers (call on newCard() function and when user can change your card)
function populateCard() {
    if (!inGame) document.getElementById('errors').innerText = 'You must start new game first!';
    else {
        let numbers = [];
        for (i=1; i<=totalNumbers; i++) {
            numbers.push(i)
        }
        let cards = document.querySelectorAll('.number');
        cards.forEach(element => {
            let casualNumb = Math.floor(Math.random() * numbers.length);
            let number = numbers[casualNumb];
            element.innerText = number;
            numbers.splice(numbers.indexOf(number), 1);
        });
    }
}

function genBoard() {
    let mainContainer = document.getElementById('mainNumbersContainer');
    let container = document.createElement('div');
    container.classList.add('row');
    for (i=1; i<=90; i++) {
        let div = document.createElement('div');
        div.classList.add('col');
        div.classList.add('mainNumbers');
        div.innerHTML = '<span>'+i+'</span>';
        container.appendChild(div);
    }
    mainContainer.appendChild(container);
}

//manages the logic of the game
function startGame() {
    if (money > 0) {   //check if the user have bet
        if (!inGame) { //check if there is already a game in progress
            document.getElementById('errors').innerText = 'You must start new game first!';
            money = 0; //reset the bet
        }
        else { //if all ok start the game
            document.getElementById('tabellone').innerText = 'Draw in progress...';
            let credits = +document.getElementById('credits').innerText;
            let newtotal = credits - money;
            document.getElementById('credits').innerText = newtotal; //change the credits HTML tag
            let xhr = new XMLHttpRequest(); //and simultaneously start an AJAx call that updates the DB
            xhr.open('POST', 'php/api/recharge.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send("newamount=" + newtotal);
            let numbers = []; //Populate an array with the total of the numbers in the game
            for (let i=1; i<=totalNumbers; i++) {
            numbers.push(i)
            }
            let total = 0;
            let int = setInterval(() => {
                if (total < extractions) {
                let number = numbers[Math.floor(Math.random() * numbers.length)];
                numbers.splice(numbers.indexOf(number), 1);
                total++;
                checkMain(number); //check the board numbers
                checknumbers(number); //and check the user card numbers
                } else {
                    // handling score and win <----
                    checkWin(); //check if the user have win
                    inGame = false; //change in false because the game is ended
                    document.getElementById('tabellone').innerText = 'Draw Ended!';
                    recordHistory(); //record this game in games history
                    printHistory(); //print the games history updated on page
                    clearInterval(int); //stop the draw interval
                }
            }, 500);
        }
    } else {
        document.getElementById('errors').innerText = 'You must bet first!';
    }
}

//check the numbers on the board and mark them if drawn
function checkMain(number) {
    let cardNumbers = document.querySelectorAll('.mainNumbers');
    cardNumbers.forEach(element => {
        if (element.innerText == number) {
            element.classList.add('extracted');
        }
    });
}

//check the numbers on the user card and mark them if drawn
function checknumbers(number) {
    let cardNumbers = document.querySelectorAll('.number');
    cardNumbers.forEach(element => {
        if (element.innerText == number) {
            element.classList.add('extracted');
        }
    });
}

//check in DB the user credit ajax request
function checkCredits(value, div) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/api/checkCredits.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send();
    xhr.onreadystatechange = () => {
        if (xhr.readyState = 4){
            setMoney(value, div);
        } else return false;
    }
}

//update in case of rechage account
function recharge() {
    let recargeValue = +document.getElementById('recargeamount').value;
    let creditsAmount = +document.getElementById('credits').innerText;
    if (recargeValue > 0) {//here update the HTML
        let total = recargeValue + creditsAmount;
        document.getElementById('credits').innerText = total;
        let xhr = new XMLHttpRequest();//at the same time update the DB with an AJAX call
        xhr.open('POST', 'php/api/recharge.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send("newamount=" + total);
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4) {
                if (xhr.responseText == 'true') document.getElementById('recageHelp').innerText = 'Recharge successfull';
                else document.getElementById('recageHelp').innerText = 'Error retry...';
            }
        }
    }
}

function checkWin() {
    let firstRow = 0;
    let secondRow = 0;
    let thirdRow = 0;
    let cardNumbers = document.querySelectorAll('.number');
    cardNumbers.forEach(element => {
        if (element.classList.contains('extracted')) {
            let fieldNumber = parseInt(element.getAttribute('data-number'));
            if (fieldNumber >= 1 && fieldNumber <= 5) firstRow++;
            if (fieldNumber >= 6 && fieldNumber <= 10) secondRow++;
            if (fieldNumber >= 11 && fieldNumber <= 15) thirdRow++;
        }
    });
    if (firstRow < 5 && secondRow < 5 && thirdRow < 5) {
        score = Math.max(firstRow, secondRow, thirdRow);
        if (score > 2) {
            if (score == 3) win = money * 2;
            if (score == 4) win = money * 3;
            if (score == 5) win = money * 5;
        }
    } else {
        win = money * 25;
        score = 15;
    }
    if (win > 0) {
        let credits = +document.getElementById('credits').innerText;
        document.getElementById('errors').innerHTML = "You have <strong>WIN: "+win+" €</strong>";
        let newtotal = credits + win;
        document.getElementById('credits').innerText = newtotal;
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/api/recharge.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send("newamount=" + newtotal);
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4) {
                console.log('Update successfull');
            }
        }
    } else  document.getElementById('errors').innerHTML = 'You have lost... retry!'
}

// update the DB history with the data of the game just ended (call this function every game ended)
function recordHistory() {
    let scoreText = '';
    if (score < 3) scoreText = '---';
    if (score == 3) scoreText = 'Terno';
    if (score == 4) scoreText = 'Quatern';
    if (score == 5) scoreText = 'Five';
    if (score == 15) scoreText = 'BINGO';
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/api/recordHistory.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("money=" + money + "&score=" + scoreText + "&win=" + win);
    xhr.onreadystatechange = () => {
        if (xhr.status != 200) console.log(xhr.responseText);
        else printHistory();
    }
}

//print the DB games history in the HTML modal (call this function every game ended)
function printHistory() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/api/printHistory.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send();
    xhr.onreadystatechange = () => {
        if (xhr.status == 200) {
            let history = JSON.parse(xhr.responseText);
            let tbody = document.getElementById('history');
            tbody.innerHTML = '';
            history.forEach(element => {
                let row = document.createElement('tr');
                let col1 = document.createElement('td');
                col1.innerHTML = '<h6>'+element.date+'</h6>';
                col1.classList.add('text-center');
                col1.classList.add('pt-2');
                let col2 = document.createElement('td');
                col2.classList.add('text-center');
                col2.classList.add('pt-2');
                col2.innerHTML = '<h6>'+element.bet+' €</h6>';
                let col3 = document.createElement('td');
                col3.classList.add('text-center');
                col3.classList.add('pt-2');
                col3.innerHTML = '<h6>'+element.result+'</h6>';
                let col4 = document.createElement('td');
                col4.classList.add('text-center');
                col4.classList.add('pt-2');
                col4.innerHTML = '<h6>'+element.win+' €</h6>';
                row.appendChild(col1);
                row.appendChild(col2);
                row.appendChild(col3);
                row.appendChild(col4);
                tbody.appendChild(row);
            });
        }
        else console.log('Query Error');;
    }
}
